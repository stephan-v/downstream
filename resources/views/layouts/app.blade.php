@include('layouts/header')

<nav class="dashboard-navigation d-flex justify-content-between">
    <a href="{{ url('/') }}" class="brand">
        @svg('downstream')
    </a>

    @if (Auth::check())
        <logout-button>LOG OUT</logout-button>
    @else
        <login-button></login-button>
    @endif
</nav><!-- /.dashboard-navigation -->

<main>
    @yield('content')
</main>
