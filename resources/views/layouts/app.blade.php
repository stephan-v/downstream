@include('layouts/header')

<nav class="dashboard-navigation d-flex justify-content-between">
    <a href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
    </a>

    <a href="{{ url('/logout') }}">logout</a>
</nav><!-- /.dashboard-navigation -->

<main>
    @yield('content')
</main>

@include('layouts/footer')
