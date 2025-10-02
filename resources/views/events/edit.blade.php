@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-dark text-center fw-bold fs-5">
                ✏️ Edit Event
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

                <form action="{{ route('events.update', $event->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Venue</label>
                        <input type="text" name="venue" value="{{ old('venue', $event->venue) }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Capacity</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $event->capacity) }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Event Date</label>
                        <input type="date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning">Update Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
