<?php

namespace App\Http\Controllers;

use App\Action;
use App\Project;
use App\Server;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActionServerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $action = Action::findOrFail($request->action_id);

        // Attach record to the pivot table.
        $action->servers()->attach($request->server_id);

        return response(null, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @param Server $server
     * @param Request $request
     * @return Response
     */
    public function destroy(Project $project, Server $server, Request $request)
    {
        /** @var Action $action */
        $action = Action::findOrFail($request->action_id);

        // Detach record from the pivot table.
        $action->servers()->detach($server->id);

        return response(null, Response::HTTP_OK);
    }
}
