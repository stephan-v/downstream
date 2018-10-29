@include('layouts/header')

<section class="hero d-flex align-items-center position-relative">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="intro">
            <h1>Powerful and intuitive <br> instant deployments</h1>

            <p class="lead text-light">
                <span class="line"></span>
                <span>Built for developers.</span>
            </p><!-- /.lead -->
        </div><!-- /.intro -->

        <div class="card">
            Example
        </div><!-- /.card -->
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

<div class="container">
    <section class="text-center">
        <a href="{{ route('github') }}" class="link-unstyled">
            <div class="card mx-auto mt-5 p-3" style="width: 15rem;">
                <i class="fab fa-github-alt fa-3x"></i>
                <h5>Login with Github</h5>
            </div><!-- /.card -->
        </a>
    </section>
</div><!-- /.container -->

@include('layouts/footer')
