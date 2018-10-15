<?php

namespace App\Http\Controllers;

use App\Action;
use App\Deployment;
use App\Jobs\SSHJob;
use App\Jobs\FinishDeployment;
use App\Jobs\StartDeployment;
use App\Project;
use Illuminate\Http\Request;

class DeploymentController extends Controller
{
    /**
     * Create a deployment release.
     *
     * @param Request $request
     */
    public function deploy(Request $request)
    {
        // Fetch our owning project model.
        $project = Project::findOrFail($request->projectId);

        // Create a new deployment for this project.
        $deployment = $project->deployments()->create([
            'user_id' => auth()->id(),
            'commit' => '8a37b62'
        ]);

        // Remove old deployments from our local database.
        $this->cleanOldDeployments($project);

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
     * Clean up old deployments in the local database.
     *
     * @param Project $project
     */
    private function cleanOldDeployments(Project $project)
    {
        $deployments = $project->deployments();

        $count = $deployments->count();

        // Skip the first x max number of deployments and delete the rest.
        $skip = $project->maxDeployments;

        if ($count > $skip) {
            $deployments->skip($skip)->take($count - $skip)->delete();
        }
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
