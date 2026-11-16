@extends('layouts.app')
@section('content')
<div class="auth-wrap auth-surface">
    <div class="auth-card auth-card-modern">
        <div class="auth-brand text-center">
            <span class="auth-icon"><i class="bi bi-shield-lock-fill"></i></span>
            <span class="eyebrow">Email verification</span>
            <h1>Enter your code</h1>
            <p>Enter the 6-digit verification code sent to your registered email address.</p>
        </div>
        @if(session('success'))<div class="alert alert-success rounded-4"><i class="bi bi-check-circle me-1"></i>{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger rounded-4">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('password.otp.verify') }}" class="auth-form">
            @csrf
            <label for="email">Email address</label>
            <div class="auth-input mb-3"><i class="bi bi-envelope"></i><input id="email" class="form-control" type="email" name="email" value="{{ old('email',$email) }}" autocomplete="email" required></div>
            <label for="otp">6-digit verification code</label>
            <div class="auth-input mb-3"><i class="bi bi-key"></i><input id="otp" class="form-control otp-input" type="text" name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" minlength="6" autocomplete="one-time-code" placeholder="123456" required autofocus></div>
            <button class="btn btn-success w-100 rounded-pill py-3" type="submit"><i class="bi bi-shield-check me-1"></i>Verify code</button>
        </form>
        <a href="{{ route('password.request') }}" class="btn btn-outline-dark w-100 rounded-pill py-2 mt-3"><i class="bi bi-arrow-repeat me-1"></i>Send a new code</a>
        <a href="{{ route('login') }}" class="btn btn-link w-100 mt-2 text-decoration-none">Back to sign in</a>
    </div>
</div>
@endsection
