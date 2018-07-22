<?php

namespace App\Jobs;

use App\Ssh\BaseJob;
use App\Ssh\SSH;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CloneRepository extends BaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the bash commands that are associated with this job.
     *
     * @return array
     */
    private function getCommands()
    {
        $deploymentPath = $this->getDeploymentPath();
        $gitRepository = $this->getRepository();

        return [
            "mkdir -p $deploymentPath",
            "git clone --depth 1 $gitRepository $deploymentPath",
            "exit"
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new SSH($this->getCommands(), $this->getConfiguredServer()))->fire();
    }
}
