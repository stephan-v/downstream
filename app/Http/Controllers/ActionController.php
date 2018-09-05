<?php

namespace App\Http\Controllers;

use App\Action;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $projectId The project id to retrieve actions for.
     * @return \Illuminate\Http\Response
     * @internal param \Illuminate\Http\Request $request
     */
    public function index($projectId)
    {
        $actions = Action::where('project_id', $projectId)->get();

        return view('actions/index', compact('actions'));
    }
}
