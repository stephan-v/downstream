<?php

namespace App\Http\Controllers;

use App\Action;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PipelineController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Project $project
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Project $project, Request $request)
    {
        /** @var Action $action */
        $action = Action::findOrFail($request->action_id);
        $action = $action->load('servers');

        $project->pipeline()->attach(
            $action->id, [
                'order' => $project->actionOrder()
            ]
        );

        return response($action, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Project $project
     * @return Response
     */
    public function update(Request $request, Project $project)
    {
        $actions = $request->actions;

        // Update the 'order' column of the pivot(pipeline) table.
        for ($i = 0; $i < count($actions); ++$i) {
            $project->pipeline()->updateExistingPivot($actions[$i]['id'], ['order' => $i]);
        }

        return response(null, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @param Action $action
     * @return Response
     */
    public function destroy(Project $project, Action $action)
    {
        // Detach from the pivot.
        $project->pipeline()->detach($action->id);

        return response(null, Response::HTTP_OK);
    }
}
