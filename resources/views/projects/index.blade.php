@extends('layouts.app')

@section('content')
    <div class="container project-overview">
        <div class="row">
            <div class="col-12">
                <h1>Project overview</h1>

                <add-project></add-project>

                @if (count($projects))
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Repository</th>
                                <th>Last deployed</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>
                                        <a href="{{ route('projects.show', ['project' => $project]) }}">
                                            {{ $project->name }}
                                        </a>
                                    </td>

                                    <td>
                                        <a href="https://github.com/{{ $project->repository }}">
                                            <i class="fab fa-github"></i> {{ $project->repository }}
                                        </a>
                                    </td>

                                    <td>N/A</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-warning mt-3" role="alert">
                        Add a project to get started
                    </div>
                @endif
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
