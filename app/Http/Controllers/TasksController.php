<?php

namespace App\Http\Controllers;

use App\Jobs\CheckSSHConnection;
use App\Jobs\CloneRepository;

class TasksController extends Controller
{
    /**
     * Create a deployment release.
     *
     * @return string
     */
    public function deploy()
    {
        CloneRepository::dispatch();

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
