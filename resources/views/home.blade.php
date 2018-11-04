@include('layouts/header')

<section class="hero d-flex align-items-center position-relative">
    <div class="main-menu container position-absolute">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="#">
                <img src="#" alt="downstream">
            </a><!-- /.navbar-brand -->

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">HOME</a>
                </li><!-- /.nav-item -->

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.index') }}">PROJECTS</a>
                    </li><!-- /.nav-item -->
                @endauth

                <li class="nav-item">
                    @if (Auth::check())
                        <logout-button>LOG OUT</logout-button>
                    @else
                        <login-button>LOG IN</login-button>
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
                <span>Built for developers.</span>
            </p><!-- /.lead -->
        </div><!-- /.intro -->
    </div><!-- /.container -->

    <div class="polygons w-100 h-100 position-absolute">
        <svg viewBox="0 0 100 100">
            <polygon points="0 0, 0 100, 100 0" />
        </svg>
    </div><!-- /.polygons -->
</section><!-- /.hero -->

<section class="marketing container">
    <div class="row text-center">
        <div class="col">
            <h2>Heading</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aperiam, assumenda beatae cumque earum eligendi facilis fuga, iusto laborum.</p>
        </div><!-- /.col -->

        <div class="col">
            <h2>Heading</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aperiam, assumenda beatae cumque earum eligendi facilis fuga, iusto laborum.</p>
        </div><!-- /.col -->

        <div class="col">
            <h2>Heading</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aperiam, assumenda beatae cumque earum eligendi facilis fuga, iusto laborum.</p>
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.marketing -->

@include('layouts/footer')
