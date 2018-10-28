<?php

namespace App\Http\Controllers;

use App\Action;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Project $project
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'script' => 'required|string'
        ]);

        $action = new Action();
        $action->name = $request->name;
        $action->description = $request->description;

        // Create an array from the text input with line breaks.
        $script = preg_split("/\r\n|\n|\r/", $request->script);
        $action->script = serialize($script);

        $action->save();

        $project->actions()->attach(
            $action->id, [
                'order' => $project->actionOrder()
            ]
        );

        $action = $action->load('servers');

        return response($action->jsonSerialize(), Response::HTTP_CREATED);
    }
}
