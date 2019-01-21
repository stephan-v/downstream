@extends('layouts.app')

@section('content')
    <div class="container deployment">
        <h1 class="mt-3">Deployment steps</h1>

        <div class="alert alert-primary" role="alert">
            <!-- @TODO this should be a deployment name derived from the commit -->
            Deployment name: {{ $deployment->commit }}
        </div><!-- /.alert -->

        @unless (count($deployment->jobs))
            <div class="alert alert-warning" role="alert">
                <p>The deployment ran but no pipeline actions were associated with this deployment.
                This means actions have not been added or you have not selected servers to run the
                action on.</p>

                <a href="{{ route('pipeline', ['project' => $deployment->project->id]) }}"
                   class="mb-0">
                    Click here to check your pipeline.
                </a>
            </div>
        @endunless

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
