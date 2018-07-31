<?php

namespace App\Jobs;

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
        event(new DeploymentStarted($this->createDeployment()));
    }

    /**
     * Create a new deployment.
     */
    private function createDeployment()
    {
        $project = $this->project;

        return $project->deployments()->create([
            'commit' => 'test'
        ]);
    }
}
