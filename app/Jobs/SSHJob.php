<?php

namespace App\Jobs;

use App\Deployment;
use App\Ssh\AbstractJob;
use App\Ssh\SSH;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SSHJob extends AbstractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * CloneRepository constructor.
     *
     * @param Deployment $deployment
     * @param string $name The name of the current job.
     * @param array $commands The commands we want to run over SSH.
     */
    public function __construct(Deployment $deployment, string $name, array $commands)
    {
        parent::__construct($deployment, $name, $commands);
    }


    /**
     * Execute the job.
     *
     * @param SSH $ssh The SSH singleton to run remote commands.
     */
    public function handle(SSH $ssh)
    {
        foreach ($this->jobs as $job) {
            $ssh->setJob($job);
            $ssh->fire();
        }
    }
}
