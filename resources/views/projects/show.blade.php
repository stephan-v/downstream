@extends('layouts.app')

@section('content')
    <div class="deployment-overview d-flex align-items-center mb-4">
        <div class="project">
            <span>PROJECT</span>
            <h2 class="pt-1 pb-0">{{ $project->name }}</h2>

            <div class="skewed-border"></div>
        </div><!-- /.project -->

        <div class="environment">
            <span>ENVIRONMENT</span>
            <h2 class="pt-1 pb-0">Master</h2>
        </div><!-- /.environment -->

        <div class="start-deployment">
            @if ($project->servers)
                <start-deployment :project-id="{{ $project->id }}"></start-deployment>
            @else
                <div class="alert alert-warning mt-3" role="alert">
                    Add a server to start a new deployment.
                </div><!-- /.alert -->
            @endif
        </div><!-- /.start-deployment -->
    </div><!-- /.deployment-overview -->

    <div class="container dashboard">
        <div class="row mb-4">
            <div class="repository">
                <span>Best Project Ever /</span>

                <a href="https://github.com/{{ $project->repository }}">
                    {{ $project->repository }}
                </a>
            </div><!-- /.repository -->
        </div><!-- /.row -->

        <div class="row justify-content-center mb-4" v-cloak>
            <div class="content">
                <tabs>
                    <tab name="Deployments">
                        <h2>Recent deployments</h2>
                        
                        <deployments :project="{{ $project }}"></deployments>
                    </tab>

                    <tab name="Servers">
                        <servers :project="{{ $project }}"></servers>
                    </tab>

                    <tab name="Pipeline">
                        <div class="alert alert-warning mt-3" role="alert">
                            The pipeline contains all your actions that are performed during a deployment.
                        </div><!-- /.alert -->

                        <a href="{{ route('pipeline', ['project' => $project->id]) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                            Edit pipeline
                        </a>
                    </tab>
                </tabs>
            </div><!-- /.content -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
