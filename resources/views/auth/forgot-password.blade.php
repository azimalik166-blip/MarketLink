@extends('layouts.app')
@section('content')
<div class="auth-wrap auth-surface">
    <div class="auth-card auth-card-modern">
        <div class="auth-brand">
            <span class="auth-icon"><i class="bi bi-key-fill"></i></span>
            <span class="eyebrow">Account recovery</span>
            <h1>Forgot your password?</h1>
            <p>Enter the email address registered to your MarketLink account. We’ll send the verification code to that email.</p>
        </div>
        @if(session('success'))<div class="alert alert-success rounded-4"><i class="bi bi-check-circle me-1"></i>{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger rounded-4">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf
            <label for="email">Registered email address</label>
            <div class="auth-input mb-3"><i class="bi bi-envelope"></i><input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required autofocus></div>
            <button class="btn btn-success w-100 rounded-pill py-3" type="submit"><i class="bi bi-envelope-arrow-up me-1"></i>Send verification code</button>
        </form>
        <a href="{{ route('login') }}" class="btn btn-outline-dark w-100 rounded-pill py-2 mt-3"><i class="bi bi-arrow-left me-1"></i>Back to sign in</a>
        <p class="auth-note">Your 6-digit code is valid for 10 minutes and can be used once.</p>
    </div>
</div>
@endsection
