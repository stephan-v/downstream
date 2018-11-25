@include('layouts/header')

<nav class="dashboard-navigation">
    <a href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
</nav><!-- /.dashboard-navigation -->

<main>
    @yield('content')
</main>

@include('layouts/footer')
