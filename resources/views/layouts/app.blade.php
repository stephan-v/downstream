@include('layouts/header')

<nav>
    <a href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
</nav>

<main>
    @yield('content')
</main>

@include('layouts/footer')
