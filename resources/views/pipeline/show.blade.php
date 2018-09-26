@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-3">Available pre-defined actions</h3>

        <div class="card-deck">
            @foreach ($actions as $action)
                <div class="card text-center mb-3">
                    <div class="card-body d-flex flex-column">
                        <div class="svg-icon inline large mb-3">
                            {{ svg_icon($action->icon) }}
                        </div><!-- /.svg-icon -->

                        <h5 class="card-title">{{ $action->name }}</h5>
                        <p class="card-text">{{ $action->description }}</p>
                        <a href="#" class="btn btn-primary mt-auto">Add to pipeline</a>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            @endforeach

            <div class="card text-center mb-3">
                <div class="card-body d-flex flex-column">
                    <div class="svg-icon inline large mb-3">
                        {{ svg_icon('energy') }}
                    </div><!-- /.svg-icon -->

                    <h5 class="card-title">Custom action</h5>
                    <p class="card-text">Create your own defined action</p>
                    <a href="#" class="btn btn-primary mt-auto">Add to pipeline</a>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.row -->

        <h3 class="mb-3">Current pipeline</h3>

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
