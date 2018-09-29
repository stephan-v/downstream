<?php

namespace App\Http\Controllers;

use App\Action;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PipelineController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // The project connected to this pipeline.
        $project = Project::findOrFail($id);

        // Available actions to choose from.
        $actions = Action::all();

        return view('pipeline/show', compact('actions', 'project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        // The project connected to this pipeline.
        $project = Project::findOrFail($id);

        $project->actions()->attach($request->action_id);

        return response(null, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $actionId
     * @return Response
     * @internal param $actionId
     * @internal param Request $request
     */
    public function destroy(int $projectId, int $actionId, int $serverId)
    {
        /** @var Action $action */
        $action = Action::findOrFail($actionId);

        // Sync to the pivot table with 'project_id' as extra value.
        $action->servers()->detach($serverId);

        return response(null, Response::HTTP_OK);
    }
}
