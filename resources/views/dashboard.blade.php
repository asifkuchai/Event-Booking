@extends('layouts.auth')

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Event Booking Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('events.index') }}" class="btn btn-outline-light btn-sm">Events</a>
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-light btn-sm">My Bookings</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Dashboard content -->
<div class="container my-4">
    <div class="row g-3">
        <!-- My Bookings -->
        <div class="col-md-4 col-sm-12">
            <div class="card shadow-sm rounded-4 h-100">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <h5 class="card-title">🎟️ My Bookings</h5>
                    <p class="fs-3 fw-bold mb-1">{{ $eventsBookedCount }}</p>
                    <p class="text-muted mb-0">Total events you have booked</p>
                </div>
            </div>
        </div>

        <!-- Active Users Last Month -->
        <div class="col-md-4 col-sm-12">
            <div class="card shadow-sm rounded-4 h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center mb-2">🌟 Active Users Last Month</h5>
                    <div class="overflow-auto" style="max-height: 150px;">
                        @if($activeUsers->isEmpty())
                            <p class="mb-0 small text-muted text-center">No users with >3 bookings</p>
                        @else
                            @foreach($activeUsers as $u)
                                <div class="d-flex justify-content-between align-items-center mb-1 px-2">
                                    <span class="fw-medium small">{{ $u->name }}</span>
                                    <span class="badge bg-success rounded-pill small">{{ $u->bookings_count }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 5 Upcoming Events -->
        <div class="col-md-4 col-sm-12">
            <div class="card shadow-sm rounded-4 h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center mb-2">📅 Top 5 Upcoming Events</h5>
                    <ul class="list-group list-group-flush overflow-auto" style="max-height: 150px;">
                        @forelse($upcomingEvents as $event)
                            @php
                                $booked = $event->bookings()->sum('tickets');
                                $available = $event->capacity - $booked;
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $event->title }} ({{ $event->event_date->format('d M Y') }})
                                <span class="badge bg-success rounded-pill">{{ $available }} seats left</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center">No upcoming events.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Occupancy Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="card-title">📊 Event Occupancy</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center mb-0">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Capacity</th>
                                    <th>Booked Tickets</th>
                                    <th>Occupancy %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventsWithOccupancy as $event)
                                    @php $booked = $event->bookings()->sum('tickets'); @endphp
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->event_date ? $event->event_date->format('d M Y') : 'N/A' }}</td>
                                        <td>{{ $event->capacity }}</td>
                                        <td>{{ $booked }}</td>
                                        <td>{{ $event->occupancy }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
