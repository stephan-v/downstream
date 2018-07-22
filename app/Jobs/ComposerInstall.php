<?php

namespace App\Jobs;

use App\Ssh\BaseJob;
use App\Ssh\SSH;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ComposerInstall extends BaseJob implements ShouldQueue
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

        return [
            "cd $deploymentPath",
            "composer install -o --no-interaction --prefer-dist",
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ssh = new SSH(
            $this->getCommands(),
            $this->getConfiguredServer(),
            (new \ReflectionClass($this))->getShortName()
        );

        $ssh->fire();
    }
}
