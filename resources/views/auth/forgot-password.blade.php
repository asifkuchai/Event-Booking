@extends('layouts.auth')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-center bg-warning text-white fw-bold fs-5">
                🔄 Forgot Your Password?
            </div>
            <div class="card-body p-4">
                <p class="mb-3 text-center text-muted">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </p>

                <!-- Session Status -->
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">📧 Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning btn-lg">
                            Email Password Reset Link
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
