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
     * The newly created deployment.
     *
     * @var Deployment $deployment
     */
    public $deployment;

    /**
     * Deployment constructor.
     *
     * @param Deployment $deployment The newly created deployment.
     * @internal param GithubClient $client The GithubClient Guzzle instance.
     */
    public function __construct(Deployment $deployment)
    {
        $this->deployment = $deployment;
        $this->createDeploymentChain($deployment->project);
    }

    /**
     * Create the chain of deployment jobs.
     *
     * If any of these jobs fail the entire deployment fails.
     *
     * @param Project $project The project to create the deployment chain for.
     */
    private function createDeploymentChain(Project $project)
    {
        $chain = [];

        foreach ($project->actions as $action) {
            $chain[] = new SSHJob($this->deployment, $action);
        }

        $chain[] = new FinishDeployment($this->deployment);

        // Continue the chain when this initial job has finished.
        $this->chain($chain);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        event(new DeploymentStarted($this->deployment));
    }
}
