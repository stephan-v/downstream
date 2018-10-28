<?php

namespace App\Http\Controllers;

use App\Deployment;
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
     */
    public function deploy(Project $project)
    {
        // Create a new deployment for this project.
        $deployment = $project->deployments()->create([
            'user_id' => auth()->id(),
            'commit' => '8a37b62'
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
