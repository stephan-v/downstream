@extends('layouts.app')

@section('content')
    <div class="container project-pipeline">
        <div class="row">
            <div class="col-12">
                <actions></actions>

                @foreach ($actions as $action)
                    {{ $action }}
                @endforeach
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
