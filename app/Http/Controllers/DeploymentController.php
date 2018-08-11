<?php

namespace App\Http\Controllers;

use App\Deployment;
use App\Jobs\CleanOldReleases;
use App\Jobs\CloneRepository;
use App\Jobs\ComposerInstall;
use App\Jobs\FinishDeployment;
use App\Jobs\StartDeployment;
use App\Project;
use App\Server;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DeploymentController extends Controller
{
    /**
     * Create a deployment release.
     *
     * @param Request $request
     */
    public function deploy(Request $request)
    {
        $project = Project::findOrFail($request->projectId);

        // Create a new deployment for this project.
        $deployment = $project->deployments()->create([
            'user_id' => auth()->id(),
            'commit' => '8a37b62'
        ]);

        StartDeployment::dispatch($deployment)->chain([
            new CloneRepository($deployment),
            new ComposerInstall($deployment),
            new CleanOldReleases($deployment),
            new FinishDeployment($deployment)
        ]);

        // Remove old deployments from our local database.
        $this->cleanOldDeployments($project);
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
     * @param int $serverId The server id we want retrieve a model for.
     */
    public function connection(int $serverId)
    {
        $server = Server::findOrFail($serverId);

        $process = new Process("ssh -q $server->target exit");
        $process->run();

        if (!$process->isSuccessful()) {
            $server->status = Server::FAILED;
            $server->save();

            throw new ProcessFailedException($process);
        }

        $server->status = Server::SUCCESSFUL;
        $server->save();
    }

    /**
     * Display the specified resource.
     *
     * @param int $projectId
     * @param int $deploymentId
     * @return \Illuminate\Http\Response
     */
    public function show(int $projectId, int $deploymentId)
    {
        $deployment = Deployment::findOrFail($deploymentId);

        return view('deployments/show', compact('deployment'));
    }
}
