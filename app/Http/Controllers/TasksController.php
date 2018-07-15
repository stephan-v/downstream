<?php

namespace App\Http\Controllers;

use App\Jobs\CloneRepository;

class TasksController extends Controller
{
    public function index()
    {
        //
        CloneRepository::dispatch();

        return view('welcome');
    }
}
