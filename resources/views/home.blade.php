@include('layouts/header')

<section class="hero d-flex align-items-center position-relative">
    <div class="skew"></div>

    <div class="main-menu container position-absolute">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="#">downstream</a>

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
                Feel confident in your deployments with an easy to use, powerful and and flexible
                deployment service.
            </p><!-- /.lead -->
        </div><!-- /.intro -->

        <img src="/images/downstream.png" alt="" class="teaser-image">
    </div><!-- /.container -->
</section><!-- /.hero -->

<section class="container features">
    <div class="row text-center">
        <div class="col-md">
            @svg('001-software', 'mb-3')

            <p>Get insight in your deployments with real-time feedback to let you know exact what
            is happening during your deployment process at any time.</p>
        </div><!-- /.col-md -->

        <div class="col-md">
            @svg('002-inspection', 'mb-3')

            <p>Highly customizable to suit your needs for every type of deployment. Create an
            entirely custom process or make a selection from our pre-defined deployment steps.</p>
        </div><!-- /.col-md -->

        <div class="col-md">
            @svg('003-atom', 'mb-3')

            <p>Atomic deployments ensure zero downtime. If anything goes wrong during your
            deployment process downstream will detect it and cancel your deployment.</p>
        </div><!-- /.col-md -->
    </div><!-- /.row -->
</section><!-- /.features -->

<div style="margin-top: 500px"></div>

@include('layouts/footer')
