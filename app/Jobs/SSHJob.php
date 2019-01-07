<?php

namespace App\Jobs;

use App\Action;
use App\Deployment;
use App\Events\DeploymentFinished;
use App\Job;
use App\Services\Ssh\CompilesCommandsTrait;
use App\Services\Ssh\SSH;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * The SSHJob class runs a job per server and executes the script from the corresponding action.
 */
class SSHJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CompilesCommandsTrait;

    /**
     * The freshly started deployment.
     *
     * @var Deployment $deployment
     */
    protected $deployment;

    /**
     * The created jobs.
     *
     * @var Job[] $jobs
     */
    protected $jobs = [];

    /**
     * CloneRepository constructor.
     *
     * @param Deployment $deployment
     * @param Action $action
     */
    public function __construct(Deployment $deployment, Action $action)
    {
        $this->deployment = $deployment;
        $this->persistJobs($action);
    }

    /**
     * Save the jobs to the database.
     *
     * @param Action $action The action that we want to persist before execution.
     */
    private function persistJobs(Action $action)
    {
        foreach ($action->servers as $server) {
            $job = new Job();

            $job->name = $action->name;
            $job->commands = $this->compileWithBlade($server, $action->script);
            $job->deployment()->associate($this->deployment);
            $job->server()->associate($server);
            $job->status = Job::PENDING;

            $this->jobs[] = tap($job)->save();
        }
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
        $deployment->finished_at = now();
        $deployment->status = Deployment::FAILED;
        $deployment->save();

        event(new DeploymentFinished($deployment, Deployment::FAILED));
    }
}
