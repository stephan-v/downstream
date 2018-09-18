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
        $project = Project::findOrFail($id);

        return view('pipeline/show', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var Action $action */
        $action = Action::findOrFail($request->action_id);

        // Sync to the pivot table with 'project_id' as extra value.
        $action->servers()->attach($request->server_id);

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
