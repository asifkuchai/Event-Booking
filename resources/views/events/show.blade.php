@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white text-center fw-bold fs-5">
                🔍 Event Details
            </div>
            <div class="card-body">
                <p><strong>Title:</strong> {{ $event->title }}</p>
                <p><strong>Venue:</strong> {{ $event->venue }}</p>
                <p><strong>Capacity:</strong> {{ $event->capacity }}</p>
                <p><strong>Date:</strong> {{ $event->event_date->format('d M Y') }}</p>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('events.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
