<?php

namespace App\Http\Controllers;

use App\Jobs\CheckSSHConnection;
use App\Jobs\CleanOldReleases;
use App\Jobs\CloneRepository;
use App\Jobs\ComposerInstall;
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
     * @return string
     */
    public function deploy(Request $request)
    {
        $project = Project::findOrFail($request->projectId);

        // Create a new deployment for this project.
        $deployment = $project->deployments()->create([
            'commit' => 'to implement'
        ]);

        StartDeployment::dispatch($deployment)->chain([
            new CloneRepository($deployment),
            new ComposerInstall($deployment),
            new CleanOldReleases($deployment),
            new FinishDeployment($deployment)
        ]);

        // Remove old deployments from our local database.
        $this->cleanOldDeployments($project);

        return 'Starting deployment';
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

        // If we count more rows
        if ($count > $skip) {
            $deployments
                ->skip($skip)
                ->take($count - $skip)
                ->delete();
        }
    }

    /**
     * Check the SSH connection status.
     *
     * @return string
     */
    public function connection()
    {
        CheckSSHConnection::dispatch();

        return 'Checking SSH connection';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('deployments/show');
    }
}
