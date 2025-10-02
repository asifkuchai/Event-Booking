<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Event Booking')</title>
    <!-- Include CSS/JS -->
</head>
<body>
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Event Booking</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">My Bookings</a></li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page content -->
    <main>
        @yield('content')
    </main>

</body>
</html>
