<?php

namespace App\Jobs;

use App\Deployment;
use App\Events\DeploymentStarted;
use App\Project;
use App\Services\HttpClients\GithubClient;
use App\Services\HttpClients\VersionControlInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StartDeployment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The maximum number of deployments that are being kept for re-deploy purposes.
     *
     * @var int MAX_DEPLOYMENTS
     */
    private const MAX_DEPLOYMENTS = 5;

    /**
     * The freshly started deployment.
     *
     * @var Deployment $deployment
     */
    public $deployment;

    /**
     * Deployment constructor.
     *
     * @param Project $project
     * @param GithubClient $client The GithubClient Guzzle instance.
     */
    public function __construct(Project $project, GithubClient $client)
    {
        $this->deployment = $this->createDeployment($project, $client);
        $this->createDeploymentChain($project);
        $this->cleanOldDeployments($project);
    }

    /**
     * Create the deployment.
     *
     * @param Project $project The project to create the deployment for.
     * @param VersionControlInterface $client The client we want to fetch commits for.
     * @return Deployment The newly created deployment.
     */
    private function createDeployment(Project $project, VersionControlInterface $client): Deployment
    {
        $commits = $client->getCommits($project->repository);

        return $project->deployments()->create([
            'user_id' => auth()->id(),
            'commit' => $commits->sha,
            'commit_url' => $commits->html_url
        ]);
    }

    /**
     * Remove deployments exceeding the MAX_DEPLOYMENTS count from the database.
     *
     * @param Project $project The project to clean deployments for.
     */
    private function cleanOldDeployments(Project $project)
    {
        $skip = self::MAX_DEPLOYMENTS;
        $deployments = $project->deployments();
        $count = $deployments->count();

        if ($count > $skip) {
            $deployments->skip($skip)->take($count - $skip)->delete();
        }
    }

    /**
     * Create the chain of deployment jobs.
     *
     * If any of these jobs fail the entire deployment fails.
     *
     * @param Project $project The project to create the deployment chain for.
     */
    private function createDeploymentChain(Project $project)
    {
        $deployment = $this->deployment;

        // Prepare the chain of deployment jobs.
        $chain = [];

        foreach ($project->actions as $action) {
            $chain[] = new SSHJob($deployment, $action);
        }

        $chain[] = new FinishDeployment($deployment);

        // Start the chain.
        $this->chain($chain);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        event(new DeploymentStarted($this->deployment));
    }
}
