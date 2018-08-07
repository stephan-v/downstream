<?php

namespace App\Jobs;

use App\Events\DeploymentFinished;
use App\Ssh\AbstractDeployment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FinishDeployment extends AbstractDeployment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
