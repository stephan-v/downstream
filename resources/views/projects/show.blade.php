@extends('layouts.app')

@section('content')
    <div class="container dashboard">
        <div class="row">
            <ul class="list-group">
                <li class="list-group-item list-group-item-action list-group-item-info">
                    Project details
                </li>

                <li class="list-group-item">
                    <span>Repository:</span>

                    <a href="https://github.com/{{ $project->repository }}">
                        <i class="fab fa-github"></i> {{ $project->repository }}
                    </a>
                </li>

                <li class="list-group-item">
                    Deploy branch: <span class="badge badge-secondary">master</span>
                </li>
            </ul><!-- /.list-group -->
        </div><!-- /.row -->

        <div class="row justify-content-center mt-3">
            <div class="content">
                <div class="links">
                    @if ($project->servers)
                        <start-deployment :project-id="{{ $project->id }}"></start-deployment>
                    @else
                        <div class="alert alert-warning mt-3" role="alert">
                            Add a server to start a new deployment.
                        </div><!-- /.alert -->
                    @endif
                </div><!-- /.links -->

                <tabs class="mt-3">
                    <tab name="Deployments">
                        <h2>Recent deployments</h2>

                        @if (count($project->deployments))
                            <deployments :project="{{ $project }}"></deployments>
                        @else
                            <p>No recent deployments</p>
                        @endif
                    </tab>

                    <tab name="Servers">
                        <servers :project="{{ $project }}"></servers>
                    </tab>
                </tabs>
            </div><!-- /.content -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
