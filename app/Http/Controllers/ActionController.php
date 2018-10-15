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
        $action->script = serialize([$request->script]);
        $action->save();

        $project->actions()->attach(
            $action->id, [
                'order' => $project->actionOrder()
            ]
        );

        return response($action->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
