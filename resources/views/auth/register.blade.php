@extends('layouts.auth')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-center bg-success text-white fw-bold fs-5">
                📝 Register for Event Booking
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">👤 Name</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autofocus>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">📧 Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">🔑 Password</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">✅ Confirm Password</label>
                        <input id="password_confirmation" type="password"
                               class="form-control"
                               name="password_confirmation" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">Register</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p class="small mb-0">Already registered?
                        <a href="{{ route('login') }}" class="text-primary text-decoration-none">
                            Login here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
