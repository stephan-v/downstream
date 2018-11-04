<?php

namespace App\Http\Controllers;

use App\Deployment;
use App\Jobs\SSHJob;
use App\Jobs\FinishDeployment;
use App\Jobs\StartDeployment;
use App\Project;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class DeploymentController extends Controller
{
    /**
     * Create a deployment release.
     *
     * @param Project $project The project we are creating a deployment for.
     */
    public function deploy(Project $project)
    {
        // @TODO refactor to a service. Purely for testing purposes.
        $user = Auth::user();

        $client = new Client([
            'base_uri' => 'https://api.github.com',
            'headers' => [
                'Authorization' => 'token ' . decrypt($user->access_token)
            ]
        ]);

        $response = $client->request('GET', '/repos/stephan-v/beerquest/commits/master');
        $body = json_decode($response->getBody());

        // Create a new deployment for this project.
        $deployment = $project->deployments()->create([
            'user_id' => auth()->id(),
            'commit' => $body->sha,
            'commit_url' => $body->html_url
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
