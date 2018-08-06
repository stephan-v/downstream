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
     * The deployment instance.
     *
     * @var Deployment
     */
    private $deployment;

    /**
     * StartDeployment constructor.
     *
     * @param Deployment $deployment
     */
    public function __construct(Deployment $deployment)
    {
        $this->deployment = $deployment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $deployment = $this->deployment;
        $deployment->status = 0;
        $deployment->save();

        event(new DeploymentFinished($deployment));
    }
}
