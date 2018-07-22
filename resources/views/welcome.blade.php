@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="content">
                <div class="links">
                    <a @click.prevent="getConnectionStatus" href="#">Get connection status</a>
                    <a @click.prevent="deploy" href="#">Run deployment task</a>
                </div><!-- /.links -->

                <pre id="log"></pre>
            </div><!-- /.content -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
