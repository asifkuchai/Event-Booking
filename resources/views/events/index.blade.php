@extends('layouts.auth')

@section('content')
<!-- Navbar -->
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
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-light px-3">My Bookings</a>
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
                📅 Event List
            </div>
            <div class="card-body">

                <!-- Search & Filter -->
                <form method="GET" action="{{ route('events.index') }}" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Search Title">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="venue" value="{{ $venue ?? '' }}" class="form-control" placeholder="Venue">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="from_date" value="{{ $from_date ?? '' }}" class="form-control" placeholder="From">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="to_date" value="{{ $to_date ?? '' }}" class="form-control" placeholder="To">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('events.create') }}" class="btn btn-success">+ Create Event</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Venue</th>
                                <th>Capacity</th>
                                <th>Available Seats</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($events as $event)
                            @php
                                $booked = $event->bookings()->sum('tickets');
                                $available = $event->capacity - $booked;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration + ($events->currentPage()-1) * $events->perPage() }}</td>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->venue }}</td>
                                <td>{{ $event->capacity }}</td>
                                <td>{{ $available > 0 ? $available : 'Sold Out' }}</td>
                                <td>{{ $event->event_date ? $event->event_date->format('d M Y') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    @if($available > 0)
                                       <a href="{{ route('bookings.createForEvent', $event->id) }}" class="btn btn-success btn-sm">Book</a>
                                    @endif
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No events found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $events->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
