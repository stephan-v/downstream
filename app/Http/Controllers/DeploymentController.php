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
     * @return string
     */
    public function deploy(Request $request)
    {
        $project = Project::findOrFail($request->projectId);
        $server = Server::findOrFail($request->serverId);

        $configuration = new DeploymentConfiguration($project, $server);

        StartDeployment::dispatch($project)->chain([
            new CloneRepository($configuration),
            new ComposerInstall($configuration),
            new CleanOldReleases($configuration),
            new FinishDeployment()
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
