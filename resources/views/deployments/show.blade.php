@extends('layouts.app')

@section('content')
    <div class="container deployment">
        <table class="table position-relative mt-3">
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
    </div><!-- /.container -->
@endsection
