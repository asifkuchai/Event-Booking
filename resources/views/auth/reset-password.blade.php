@extends('layouts.auth')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-center bg-success text-white fw-bold fs-5">
                🔄 Reset Password
            </div>
            <div class="card-body p-4">

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">📧 Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">🔑 Password</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">🔑 Confirm Password</label>
                        <input id="password_confirmation" type="password"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               name="password_confirmation" required autocomplete="new-password">
                        @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            Reset Password
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
