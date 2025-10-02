@extends('layouts.auth')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Event Booking</a>

        <!-- Toggler/collapsible button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar buttons -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="ms-auto d-flex gap-3 align-items-center">
                <a href="{{ route('events.index') }}" class="btn btn-outline-light px-3">Events</a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light px-3">dashboard</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger px-3">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="row justify-content-center mt-3">
    <div class="col-md-10">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white fw-bold fs-5 text-center">
                🎟️ Bookings List
            </div>
            <div class="card-body">

                <!-- Search & Filter -->
                <form method="GET" action="{{ route('bookings.index') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by Event" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="event_id" class="form-select">
                            <option value="">-- Filter by Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="{{ route('bookings.create') }}" class="btn btn-success">+ New Booking</a>
                    </div>
                </form>

                <!-- Booking Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Event</th>
                                <th>Tickets</th>
                                <th>Booked At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->event->title }}</td>
                                    <td>{{ $booking->tickets }}</td>
                                    <td>{{ $booking->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $bookings->withQueryString()->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
