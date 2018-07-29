@extends('layouts.app')

@section('content')
    <div class="container deployment">
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
            </ul>
        </div><!-- /.row -->

        <div class="row justify-content-center mt-3">
            <div class="content">
                <div class="links">
                    <connection-status></connection-status>

                    <button type="button" class="btn btn-success" @click="deploy">
                        Run deployment task
                    </button>
                </div><!-- /.links -->

                <table class="table mt-3">
                    <thead>
                    <tr>
                        <th>Executed action</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody is="task-listener" name="CloneRepository"></tbody>
                    <tbody is="task-listener" name="ComposerInstall"></tbody>
                    <tbody is="task-listener" name="CleanOldReleases"></tbody>
                </table>
            </div><!-- /.content -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
