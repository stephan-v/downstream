<?php

namespace App\Http\Controllers;

use App\Action;
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
     * @param int $actionId
     * @return Response
     * @internal param $actionId
     * @internal param Request $request
     */
    public function destroy(int $actionId, int $serverId)
    {
        /** @var Action $action */
        $action = Action::findOrFail($actionId);

        // Detach record from the pivot table.
        $action->servers()->detach($serverId);

        return response(null, Response::HTTP_OK);
    }
}
