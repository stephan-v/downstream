<?php

namespace App\Http\Controllers;

use App\Deployment;
use App\Domain\HttpClients\GithubClient;
use App\Jobs\SSHJob;
use App\Jobs\FinishDeployment;
use App\Jobs\StartDeployment;
use App\Project;

class DeploymentController extends Controller
{
    /**
     * Create a deployment release.
     *
     * @param Project $project The project we are creating a deployment for.
     * @param GithubClient $client The GithubClient Guzzle instance.
     */
    public function deploy(Project $project, GithubClient $client)
    {
        $commits = $client->getCommits();

        /** @var Deployment $deployment */
        $deployment = $project->deployments()->create([
            'user_id' => auth()->id(),
            'commit' => $commits->sha,
            'commit_url' => $commits->html_url
        ]);

        // Prepare the chain of deployment jobs.
        $chain = [];

        foreach ($project->actions as $action) {
            $chain[] = new SSHJob($deployment, $action);
        }

        $chain[] = new FinishDeployment($deployment);

        // Start the job chain that we have just built.
        StartDeployment::dispatch($deployment)->chain($chain);
    }

    /**
     * Display the specified resource.
     *
     * @param int $projectId
     * @param Deployment $deployment
     * @return \Illuminate\Http\Response
     */
    public function show(int $projectId, Deployment $deployment)
    {
        // Lazy eager load the server that the job runs on as well.
        $deployment->jobs->load('server');

        return view('deployments/show', compact('deployment'));
    }
}
