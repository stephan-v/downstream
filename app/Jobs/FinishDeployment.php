<?php

namespace App\Jobs;

use App\Deployment;
use App\Events\DeploymentFinished;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FinishDeployment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The freshly started deployment.
     *
     * @var Deployment $deployment
     */
    public $deployment;

    /**
     * Deployment constructor.
     *
     * @param Deployment $deployment;
     */
    public function __construct(Deployment $deployment)
    {
        $this->deployment = $deployment;
    }

    /**
     * Mark the deployment as finished within storage.
     *
     * @return Deployment The saved deployment.
     */
    private function markDeploymentAsFinished(): Deployment
    {
        $deployment = $this->deployment;
        $deployment->finished_at = now();
        $deployment->status = Deployment::FINISHED;
        $deployment->save();

        return $deployment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $deployment = $this->markDeploymentAsFinished();

        event(new DeploymentFinished($deployment, Deployment::FINISHED));
    }
}
