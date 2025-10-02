@extends('layouts.auth')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-center bg-secondary text-white fw-bold fs-5">
                🔒 Confirm Your Password
            </div>
            <div class="card-body p-4">
                <p class="mb-3 text-center text-muted">
                    This is a secure area of the application. Please confirm your password before continuing.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="password" class="form-label">🔑 Password</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-secondary btn-lg">
                            Confirm
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
