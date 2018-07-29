@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome</h1>

        @auth
            <ul>
                <li>
                    <a href="{{ route('projects.index') }}">Projects</a>
                </li>
            </ul>
        @endauth

        @guest
            <p>Please log in.</p>
        @endguest
    </div><!-- /.container -->
@endsection
