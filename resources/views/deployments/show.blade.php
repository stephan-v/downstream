@extends('layouts.app')

@section('content')
    <div class="container deployment">
        <h1>Deployment steps</h1>

        <div class="alert alert-primary" role="alert">
            <!-- @TODO this should be a deployment name derived from the commit -->
            Deployment name: {{ $deployment->commit }}
        </div><!-- /.alert -->

        @foreach ($deployment->jobs->groupBy('name') as $groupedJobs)
            <div class="card mt-3">
                <div class="card-header">
                    {{ $groupedJobs->first()->name }}
                </div><!-- /.card-header -->

                <ul class="list-group list-group-flush">
                    @foreach ($groupedJobs as $job)
                        <job-listener :job="{{ $job }}"></job-listener>
                    @endforeach
                </ul>
            </div><!-- /.card -->
        @endforeach
    </div><!-- /.container -->
@endsection
