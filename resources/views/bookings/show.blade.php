@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white fw-bold fs-5 text-center">
                📄 Booking Details
            </div>
            <div class="card-body">

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>User</th>
                            <td>{{ $booking->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Event</th>
                            <td>{{ $booking->event->title }}</td>
                        </tr>
                        <tr>
                            <th>Tickets</th>
                            <td>{{ $booking->tickets }}</td>
                        </tr>
                        <tr>
                            <th>Booking Date</th>
                            <td>{{ $booking->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back to List</a>
                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning">Edit Booking</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
