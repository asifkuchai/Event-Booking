@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-success text-white text-center fw-bold fs-5">
                    🎫 Book Tickets
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

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                        {{-- Event Selection --}}
                        <div class="mb-3">
                            <label for="event_id" class="form-label">Event</label>
                            <select name="event_id" id="event_id" class="form-select" required
                                {{ isset($selectedEvent) ? 'disabled' : '' }}>
                                <option value="">-- Choose an Event --</option>
                                @foreach ($events as $event)
                                    <option value="{{ $event->id }}"
                                        {{ old('event_id', $selectedEvent ?? '') == $event->id ? 'selected' : '' }}>
                                        {{ $event->title }} (Available:
                                        {{ $event->capacity - $event->bookings()->sum('tickets') }})
                                    </option>
                                @endforeach
                            </select>

                            @if (isset($selectedEvent))
                                {{-- Hidden field so value gets submitted even if dropdown is disabled --}}
                                <input type="hidden" name="event_id" value="{{ $selectedEvent }}">
                            @endif

                            @error('event_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tickets --}}
                        <div class="mb-3">
                            <label for="tickets" class="form-label">Number of Tickets</label>
                            <input type="number" name="tickets" id="tickets" class="form-control"
                                value="{{ old('tickets', 1) }}" min="1" required>
                            @error('tickets')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary">Book</button>
                    </form>
                </div>
@endsection
