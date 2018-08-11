@extends('layouts.app')

@section('content')
    <div class="container deployment">
        <h1>Deployment steps</h1>

        <div class="alert alert-primary" role="alert">
            <!-- @TODO this should be a deployment name derived from the commit -->
            Deployment name: {{ $deployment->commit }}
        </div><!-- /.alert -->

        <table class="table position-relative mt-3">
            <thead>
                <tr>
                    <th>Executed action</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>

            <tbody is="task-listener" name="CloneRepository" :deployment-id="{{ $deployment->id }}"></tbody>
            <tbody is="task-listener" name="ComposerInstall" :deployment-id="{{ $deployment->id }}"></tbody>
            <tbody is="task-listener" name="CleanOldReleases" :deployment-id="{{ $deployment->id }}"></tbody>
        </table>
    </div><!-- /.container -->
@endsection
