@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pipeline</h1>

        <div class="pipeline">
            @foreach ($project->actions as $action)
                <div class="card">
                    <div class="card-header">
                        {{ $action->name }}
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <h6 class="card-title">Will be executed on the following servers</h6>

                        @foreach ($project->servers as $server)
                            <server-checkbox :server="{{ $server }}"
                                             :pipeline-id="{{ $action->pivot->id }}"
                                             :project-id="{{ $project->id }}"
                                             :action-id="{{ $action->id }}"
                                             :initial-checked="@json($action->servers->contains('id', $server->id))">
                            </server-checkbox>
                        @endforeach
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            @endforeach
        </div><!-- /.pipeline -->
    </div><!-- /.container -->
@endsection
