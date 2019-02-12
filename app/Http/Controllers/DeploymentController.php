<?php

namespace App\Http\Controllers;

use App\Deployment;
use App\Jobs\StartDeployment;
use App\Project;
use App\Services\HttpClients\VersionControlInterface;

class DeploymentController extends Controller
{
    /**
     * Create a deployment release.
     *
     * @param Project $project The project we are creating a deployment for.
     * @param VersionControlInterface $client The GithubClient Guzzle instance.
     */
    public function deploy(Project $project, VersionControlInterface $client)
    {
        $commit = $client->getLastRepositoryCommit($project->repository);

        $deployment = $project->deployments()->create([
            'commit' => $commit->sha,
            'commit_url' => $commit->html_url,
            'message' => $commit->commit->message
        ]);

        StartDeployment::dispatch($deployment);
    }

    /**
     * Display the specified resource.
     *
     * @param int $project
     * @param Deployment $deployment
     * @return \Illuminate\Http\Response
     */
    public function show(int $project, Deployment $deployment)
    {
        // Eager load the server(s) that the actions run on.
        $deployment->jobs->load('server');

        return view('deployments.show', compact('deployment'));
    }
}
