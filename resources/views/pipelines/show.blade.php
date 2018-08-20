@extends('layouts.app')

@section('content')
    <div class="container pipeline">
        <h1>Pipeline</h1>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <h5>Git clone</h5>
                </div><!-- /.card -->
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-6">
                <div class="card">
                    <h5>Composer install</h5>
                </div><!-- /.card -->
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-6">
                <div class="card">
                    <h5>Activate new release</h5>
                </div><!-- /.card -->
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-6">
                <div class="card">
                    <h5>Purge old releases</h5>
                </div><!-- /.card -->
            </div><!-- /.col-lg-6 -->

            <div class="col-lg-6">
                <div class="card">
                    <h5>Custom SSH action</h5>
                </div><!-- /.card -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
