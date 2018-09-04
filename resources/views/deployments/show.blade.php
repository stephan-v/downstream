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

            @foreach ($deployment->jobs as $job)
                <tbody is="job-listener" :job="{{ $job }}"></tbody>
            @endforeach
        </table>
    </div><!-- /.container -->
@endsection
