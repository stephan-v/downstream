<?php

namespace App\Http\Controllers;

use App\Action;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = $request->user()->projects;
        $projects->load('deployments', 'user');


        return view('projects.index', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'repository' => ['required', 'string'],
        ]);

        /** @var Project $project */
        $project = Project::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'repository' => $request->repository
        ]);

        return response($project, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     * @return Response
     */
    public function show(Project $project)
    {
        $project->load('deployments', 'pipeline.servers', 'servers');

        // Available default pipeline actions to choose from.
        $actions = Action::where('custom', false)->get();

        return view('projects.show', compact('actions', 'project'));
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
        $request->validate([
            'name' => ['required', 'string'],
            'repository' => ['required', 'string'],
        ]);

        $input = $request->all();
        $project->fill($input);
        $project->save();

        return response($project, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response(null, Response::HTTP_OK);
    }
}
