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

        // Prepare the chain of jobs.
        $chain = [];

        foreach ($project->actions as $action) {
            $name = $action->name;
            $script = unserialize($action->script);

            $chain[] = new SSHJob($deployment, $name, $script);
        }

        $chain[] = new FinishDeployment($deployment);

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
