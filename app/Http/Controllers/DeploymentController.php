<?php

namespace App\Http\Controllers;

use App\Jobs\CheckSSHConnection;
use App\Jobs\CleanOldReleases;
use App\Jobs\CloneRepository;
use App\Jobs\ComposerInstall;
use App\Project;
use App\Server;
use App\Ssh\DeploymentConfiguration;
use Illuminate\Http\Request;

class DeploymentController extends Controller
{
    /**
     * Create a deployment release.
     *
     * @return string
     */
    public function deploy(Request $request)
    {
        $project = Project::findOrFail($request->projectId);
        $server = Server::findOrFail($request->serverId);

        $configuration = new DeploymentConfiguration($project, $server);

        // If one of these jobs fail the remaining will not execute.
        CloneRepository::dispatch($configuration)->chain([
            new ComposerInstall($configuration),
            new CleanOldReleases($configuration)
        ]);

        return 'Starting deployment';
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
