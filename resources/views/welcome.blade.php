@extends('layouts.app')

@section('content')
    <div class="container deployment">
        <div class="row justify-content-center">
            <div class="content">
                <div class="links">
                    <button type="button" class="btn btn-info" @click="getConnectionStatus">
                        Get connection status
                    </button>

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
