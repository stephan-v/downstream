@extends('layouts.app')

@section('content')
    <div class="container">
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

                <h1>Deployment tasks</h1>

                <task-listener name="CloneRepository"></task-listener>
                <task-listener name="ComposerInstall"></task-listener>
                <task-listener name="CleanOldReleases"></task-listener>
            </div><!-- /.content -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
