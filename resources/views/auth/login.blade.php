@extends('layouts.auth')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-center bg-primary text-white fw-bold fs-5">
                🔐 Login to Event Booking
            </div>
            <div class="card-body p-4">

                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">📧 Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">🔑 Password</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="d-grid gap-2">
                    <a href="{{ url('auth/google') }}" class="btn btn-danger btn-lg">
                        <i class="bi bi-google me-2"></i> Login with Google
                    </a>
                    <a href="{{ url('auth/github') }}" class="btn btn-dark btn-lg">
                        <i class="bi bi-github me-2"></i> Login with GitHub
                    </a>
                </div>

                <div class="text-center mt-3">
                    <p class="small mb-0">Don’t have an account?
                        <a href="{{ route('register') }}" class="text-primary text-decoration-none">
                            Register here
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
