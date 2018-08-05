<?php

namespace App\Http\Controllers;

use App\Jobs\CheckSSHConnection;
use App\Jobs\CleanOldReleases;
use App\Jobs\CloneRepository;
use App\Jobs\ComposerInstall;
use App\Jobs\FinishDeployment;
use App\Jobs\StartDeployment;
use App\Project;
use App\Server;
use App\Ssh\DeploymentConfiguration;
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
        $server = Server::findOrFail($request->serverId);

        $configuration = new DeploymentConfiguration($project, $server);
        $this->cleanOldDeployments($project->deployments());

        StartDeployment::dispatch($configuration, $project)->chain([
            new CloneRepository($configuration),
            new ComposerInstall($configuration),
            new CleanOldReleases($configuration),
            new FinishDeployment($project)
        ]);

        return 'Starting deployment';
    }

    /**
     * Clean up old deployments in the local database.
     *
     * @param $deployments
     * @param int $skip
     */
    private function cleanOldDeployments($deployments, $skip = 4)
    {
        $count = $deployments->count();

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
