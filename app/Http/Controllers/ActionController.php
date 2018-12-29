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
        $action->script = preg_split("/\r\n|\n|\r/", $request->script);
        $action->save();

        $project->pipeline()->attach(
            $action->id, [
                'order' => $project->actionOrder()
            ]
        );

        $action = $action->load('servers');

        // Refresh to get a database instance with default column values.
        $action->refresh();

        return response($action, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Project $project
     * @param Action $action
     * @return Response
     */
    public function update(Request $request, Project $project, Action $action)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'script' => 'required|string'
        ]);

        $action->fill($validated);
        $action->save();

        return response($action, Response::HTTP_CREATED);
    }
}
