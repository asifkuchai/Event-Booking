@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center fw-bold fs-5">
                + Create Event
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

                <form action="{{ route('events.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Venue</label>
                        <input type="text" name="venue" value="{{ old('venue') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Capacity</label>
                        <input type="number" name="capacity" value="{{ old('capacity') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Event Date</label>
                        <input type="date" name="event_date" value="{{ old('event_date') }}" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Create Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
