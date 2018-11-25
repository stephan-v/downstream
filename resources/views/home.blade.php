@include('layouts/header')

<section class="hero d-flex align-items-center position-relative">
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
            <h1>Powerful and intuitive <br> instant deployments</h1>

            <p class="lead text-light">
                <span class="line"></span>
                <span>You don't have to yell at your rubber ducky anymore.</span>
            </p><!-- /.lead -->
        </div><!-- /.intro -->
    </div><!-- /.container -->
</section><!-- /.hero -->

@include('layouts/footer')
