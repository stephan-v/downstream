<?php

namespace App\Http\Controllers;

use App\Jobs\CheckSSHConnection;
use App\Jobs\CleanOldReleases;
use App\Jobs\CloneRepository;
use App\Jobs\ComposerInstall;
use App\Ssh\DeploymentConfiguration;

class TasksController extends Controller
{
    /**
     * Create a deployment release.
     *
     * @return string
     */
    public function deploy()
    {
        $configuration = new DeploymentConfiguration();

        // This is the default PHP queue, if one of these jobs fail the remaining will not execute.
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
}
