<?php

namespace App\Http\Controllers;

use App\Jobs\CloneRepository;

class TasksController extends Controller
{
    public function deploy()
    {
        CloneRepository::dispatch();

        return 'Starting deployment';
    }
}
