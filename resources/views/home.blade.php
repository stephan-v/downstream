@include('layouts/header')

<section class="hero d-flex align-items-center position-relative">
    <div class="skew"></div>

    <div class="main-menu container position-absolute">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="#">
                <img src="#" alt="downstream">
            </a><!-- /.navbar-brand -->

            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.index') }}">PROJECTS</a>
                    </li><!-- /.nav-item -->
                @endauth

                <li class="nav-item">
                    @if (Auth::check())
                        <logout-button>LOG OUT</logout-button>
                    @else
                        <login-button></login-button>
                    @endif
                </li><!-- /.nav-item -->
            </ul><!-- /.navbar-nav -->
        </nav><!-- /.navbar -->
    </div><!-- /.container -->

    <div class="container d-flex align-items-center justify-content-between">
        <div class="intro">
            <h1>Deployments you can rely on</h1>

            <p class="lead text-light">
                No more nervous sweating before pressing that deployment button.
                Feel confident in your deployments with real-time feedback, atomic deployments and
                a well defined deployment process.
            </p><!-- /.lead -->
        </div><!-- /.intro -->
    </div><!-- /.container -->
</section><!-- /.hero -->

@include('layouts/footer')
