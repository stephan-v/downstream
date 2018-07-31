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
                    <connection-status></connection-status>
                    <start-deployment :project-id="{{ $project->id }}" :server-id="{{ $project->server->id }}"></start-deployment>
                </div><!-- /.links -->

                <tabs>
                    <tab name="Deployments">
                        <table class="table position-relative mt-3">
                            <thead>
                                <tr>
                                    <th>Started</th>
                                    <th>Commit</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr is="deployment-listener"></tr>

                                @foreach ($project->deployments as $deployment)
                                    <tr>
                                        <td>{{ $deployment->created_at->diffForHumans() }}</td>
                                        <td>{{ $deployment->commit}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </tab>

                    <tab name="Servers">
                        <div class="d-flex justify-content-between">
                            <h2>Servers</h2>
                            <add-server :project-id="{{ $project->id }}"></add-server>
                        </div><!-- /.d-flex -->

                        <table class="table position-relative mt-3">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Connect as</th>
                                <th>IP Address </th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach ($project->servers as $server)
                                    <tr>
                                        <td>{{ $server->name }}</td>
                                        <td>{{ $server->user }}</td>
                                        <td>{{ $server->ip_address }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </tab>
                </tabs>
            </div><!-- /.content -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
