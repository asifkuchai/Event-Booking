@extends('layouts.auth')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header text-center bg-info text-white fw-bold fs-5">
                📧 Verify Your Email
            </div>
            <div class="card-body p-4">

                <p class="mb-4 text-muted">
                    Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed you.
                    If you didn't receive the email, we can send another one.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success">
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                <div class="d-flex justify-content-between mt-4">
                    <!-- Resend Verification Email -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-info btn-lg">
                            Resend Verification Email
                        </button>
                    </form>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-lg">
                            Log Out
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
