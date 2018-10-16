<?php

namespace App\Jobs;

use App\Action;
use App\Deployment;
use App\Events\DeploymentFinished;
use App\Job;
use App\Server;
use App\Ssh\CompilesCommandsTrait;
use App\Ssh\SSH;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SSHJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CompilesCommandsTrait;

    /**
     * The bash commands that are associated with this job.
     *
     * @var array $commands Array of commands to run one by one on a specified server.
     */
    private $commands;

    /**
     * The freshly started deployment.
     *
     * @var Deployment $deployment
     */
    private $deployment;

    /**
     * The name of the current job.
     *
     * @var string $name
     */
    private $name;

    /**
     * The created jobs.
     *
     * @var Job[] $jobs
     */
    private $jobs;

    /**
     * CloneRepository constructor.
     *
     * @param Deployment $deployment
     * @param Action $action
     */
    public function __construct(Deployment $deployment, Action $action)
    {
        $this->deployment = $deployment;
        $this->name = $action->name;
        $this->commands = unserialize($action->script);

        $this->saveJobsToDatabase();
    }

    /**
     * Save the jobs to the database.
     */
    protected function saveJobsToDatabase()
    {
        $servers = $this->deployment->project->servers;

        foreach ($servers as $server) {
            $this->createJob($server);
        }
    }

    /**
     * Persist job to the database.
     *
     * @param Server $server
     */
    private function createJob(Server $server)
    {
        $job = new Job();

        $job->name = $this->name;
        $job->commands = $this->compileCommands($server);
        $job->deployment()->associate($this->deployment);
        $job->server()->associate($server);
        $job->status = Job::PENDING;

        $this->jobs[] = tap($job)->save();
    }

    /**
     * Execute the job.
     *
     * @param SSH $ssh The SSH singleton to run remote commands.
     */
    public function handle(SSH $ssh)
    {
        foreach ($this->jobs as $job) {
            $ssh->setJob($job);
            $ssh->fire();
        }
    }

    /**
     * The job failed to process.
     *
     * If a job failed in the chain we make sure to set the entire deployment to 'failed'.
     */
    public function failed()
    {
        $deployment = $this->deployment;
        $deployment->status = Deployment::FAILED;
        $deployment->save();

        event(new DeploymentFinished($deployment, Deployment::FAILED));
    }
}
