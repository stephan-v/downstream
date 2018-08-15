@extends('layouts.app')

@section('content')
    <div class="container project-overview">
        <div class="row">
            <div class="col-12">
                <projects :initial-projects="{{ $projects }}"></projects>
            </div><!-- /.col-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
