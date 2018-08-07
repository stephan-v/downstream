<?php

namespace App\Jobs;

use App\Server;
use App\Ssh\AbstractDeployment;
use App\Ssh\SSH;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ComposerInstall extends AbstractDeployment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the bash commands that are associated with this job.
     *
     * @param Server $server
     * @return array
     */
    private function getCommands(Server $server)
    {
        $deploymentPath = $server->releases . $this->timestamp();

        return [
            "cd $deploymentPath",
            "composer install -o --no-interaction --prefer-dist",
        ];
    }

    /**
     * Execute the job.
     *
     * @param SSH $ssh The SSH singleton to run remote commands.
     */
    public function handle(SSH $ssh)
    {
        foreach ($this->servers() as $server) {
            $ssh->setCommands($this->getCommands($server));
            $ssh->setTarget($server->target);
            $ssh->setJobName($this->getShortName());

            $ssh->fireRealTime();
        }
    }
}
