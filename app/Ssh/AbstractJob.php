<?php

namespace App\Ssh;

use App\Deployment;
use App\Server;
use App\Job;

abstract class AbstractJob {
    use CompilesCommandsTrait;

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
    protected $deployment;

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
    protected $jobs;

    /**
     * Deployment constructor.
     *
     * @param Deployment $deployment;
     * @param string $name
     * @param array $commands
     */
    public function __construct(Deployment $deployment, string $name, array $commands)
    {
        $this->deployment = $deployment;
        $this->name = $name;
        $this->commands = $commands;

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
     * The job failed to process.
     *
     * If a job failed in the chain we make sure to set the entire deployment to 'failed'.
     */
    public function failed()
    {
        $deployment = $this->deployment;
        $deployment->status = Deployment::FAILED;
        $deployment->save();
    }
}
