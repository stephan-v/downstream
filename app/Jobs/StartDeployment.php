<?php

namespace App\Jobs;

use App\Deployment;
use App\Events\DeploymentStarted;
use App\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StartDeployment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The project coupled to this deployment.
     *
     * @var Project $project
     */
    private $project;

    /**
     * StartDeployment constructor.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @internal param Project $project
     */
    public function handle()
    {
        $deployment = $this->createDeployment();

        event(new DeploymentStarted($deployment));
    }

    /**
     * Create a new deployment.
     */
    private function createDeployment(): Deployment
    {
        $project = $this->project;

        $deployment = new Deployment();
        $deployment->commit = 'test';

        $saved = $project->deployments()->save($deployment);

        if ($saved) {
            return $deployment;
        }

        throw new \RuntimeException('Deployment could not be created');
    }
}
