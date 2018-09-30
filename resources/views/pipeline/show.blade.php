@extends('layouts.app')

@section('content')
    <div class="container">
        <pipeline :actions="{{ $actions }}" :project="{{ $project }}"></pipeline>
    </div><!-- /.container -->
@endsection
