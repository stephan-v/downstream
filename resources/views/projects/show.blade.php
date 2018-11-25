@extends('layouts.app')

@section('content')
    @include('projects.header')

    <aside class="project-sidebar">
        <ul>
            <router-link :to="{ name: 'deployments' }" tag="li">
                <i class="fas fa-code"></i>
                Deployments
            </router-link>

            <router-link :to="{ name: 'servers' }" tag="li">
                <i class="fas fa-server"></i>
                Servers
            </router-link>
        </ul>
    </aside>

    <div class="container dashboard">
        <div class="row mb-4">
            <div class="repository">
                <span>Best Project Ever /</span>

                <a href="https://github.com/{{ $project->repository }}">
                    {{ $project->repository }}
                </a>
            </div><!-- /.repository -->
        </div><!-- /.row -->

        <div class="row justify-content-center mb-4" v-cloak>
            <div class="content">
                <router-view :project="{{ $project }}"></router-view>

                {{--<tabs>--}}
                    {{--<tab name="Pipeline">--}}
                        {{--<div class="alert alert-warning mt-3" role="alert">--}}
                            {{--The pipeline contains all your actions that are performed during a deployment.--}}
                        {{--</div><!-- /.alert -->--}}

                        {{--<a href="{{ route('pipeline', ['project' => $project->id]) }}" class="btn btn-primary">--}}
                            {{--<i class="fas fa-edit"></i>--}}
                            {{--Edit pipeline--}}
                        {{--</a>--}}
                    {{--</tab>--}}
                {{--</tabs>--}}
            </div><!-- /.content -->
        </div><!-- /.row -->
    </div><!-- /.container -->
@endsection
