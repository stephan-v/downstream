<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CleanOldReleases extends BaseJob implements ShouldQueue
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
        $projectPath = $this->getProjectPath();

        return [
            "ln -snf $deploymentPath $projectPath/current",
            "cd $projectPath/releases && ls -t | tail -n +6 | xargs rm -rf"
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        new SSH($this->getCommands(), $this->getConfiguredServer());
    }
}
