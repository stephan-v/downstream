@extends('layouts.app')

@section('content')
    @include('projects.header')

    <aside class="project-sidebar" v-cloak>
        <ul>
            <router-link :to="{ name: 'deployments' }" tag="li">
                <i class="fas fa-code fa-fw"></i>
                Deployments
            </router-link>

            <router-link :to="{ name: 'servers' }" tag="li">
                <i class="fas fa-server fa-fw"></i>
                Servers
            </router-link>

            <router-link :to="{ name: 'pipeline' }" tag="li">
                <i class="fas fa-ellipsis-v fa-fw"></i>
                Pipeline
            </router-link>
        </ul>
    </aside>

    <div class="container dashboard" v-cloak>
        <div class="container-offset">
            <div class="row mb-4">
                <div class="repository">
                    <span>Best Project Ever /</span>

                    <a href="https://github.com/{{ $project->repository }}">
                        {{ $project->repository }}
                    </a>
                </div><!-- /.repository -->
            </div><!-- /.row -->

            <div class="row justify-content-center mb-4">
                <div class="content">
                    <keep-alive>
                        <router-view :project="{{ $project }}" :actions="{{ $actions }}"></router-view>
                    </keep-alive>
                </div><!-- /.content -->
            </div><!-- /.row -->
        </div><!-- /.container-offset -->
    </div><!-- /.container -->
@endsection
