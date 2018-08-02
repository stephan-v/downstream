<?php

namespace App\Jobs;

use App\Ssh\AbstractDeployment;
use App\Ssh\SSH;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CloneRepository extends AbstractDeployment implements ShouldQueue
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
     * @param SSH $ssh The SSH singleton to run remote commands.
     */
    public function handle(SSH $ssh)
    {
        $ssh->setCommands($this->getCommands());
        $ssh->setTarget($this->getServerName());
        $ssh->setJobName($this->getShortName());

        $ssh->fireRealTime();
    }
}
