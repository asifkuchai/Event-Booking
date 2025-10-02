@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-white text-center fw-bold fs-5">
                ✏️ Edit Booking
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- User --}}
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Event --}}
                    <div class="mb-3">
                        <label for="event_id" class="form-label">Event</label>
                        <select name="event_id" id="event_id" class="form-select @error('event_id') is-invalid @enderror">
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ $booking->event_id == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }} (Available: {{ $event->capacity - $event->bookings()->sum('tickets') }})
                                </option>
                            @endforeach
                        </select>
                        @error('event_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Tickets --}}
                    <div class="mb-3">
                        <label for="tickets" class="form-label">Tickets</label>
                        <input type="number" name="tickets" id="tickets" class="form-control @error('tickets') is-invalid @enderror"
                               value="{{ old('tickets', $booking->tickets) }}" min="1" required>
                        @error('tickets') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-warning w-100">Update Booking</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
