<?php

namespace App\Jobs;

use App\Events\DeploymentStarted;
use App\Ssh\AbstractDeployment;
use App\Ssh\SSH;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class StartDeployment extends AbstractDeployment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the bash commands that are associated with this job.
     *
     * @return array
     */
    private function getCommands()
    {
        $gitRepository = $this->getRepository();

        return [
            "git ls-remote $gitRepository | grep HEAD | awk '{print $1}'",
            "exit"
        ];
    }

    /**
     * Execute the job.
     *
     * @param SSH $ssh
     * @return void
     * @internal param Project $project
     */
    public function handle(SSH $ssh)
    {
        $ssh->setCommands($this->getCommands());
        $ssh->setTarget($this->getServerName());
        $ssh->setJobName($this->getShortName());

        $output = $ssh->fire();

        $deployment = $this->createDeployment($output);

        event(new DeploymentStarted($deployment));
    }

    /**
     * Create a new deployment.
     *
     * @param string $commitHash The latest remote SHA1 hash.
     * @return
     */
    private function createDeployment(string $commitHash)
    {
        $project = $this->project;

        return $project->deployments()->create([
            'commit' => $commitHash
        ]);
    }
}
