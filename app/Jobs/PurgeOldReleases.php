<?php

namespace App\Jobs;

use App\Deployment;
use App\Project;
use App\Services\Ssh\CompilesCommandsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * The SSHJob class runs a job per server and executes the script from the corresponding action.
 */
class PurgeOldReleases implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CompilesCommandsTrait;

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
     * Purge deployments exceeding the MAX_DEPLOYMENTS count from the database and the filesystem.
     *
     * @param Project $project The project to clean deployments for.
     */
    private function purgeOldReleases(Project $project)
    {
        $skip = deployment::MAX_DEPLOYMENTS;
        $deployments = $project->deployments();
        $count = $deployments->count();

        if ($count > $skip) {
            $deployments->skip($skip)->take($count - $skip)->delete();
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->purgeOldReleases($this->deployment->project);
    }
}
