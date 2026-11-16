@extends('layouts.app')
@section('content')
<div class="auth-wrap auth-surface">
    <div class="auth-card auth-card-modern auth-card-register">
        <div class="auth-brand text-center">
            <span class="auth-icon"><i class="bi bi-person-plus"></i></span>
            <span class="eyebrow">Join MarketLink</span>
            <h1>Create your account</h1>
            <p>Shop local products or start your own farmer stall.</p>
        </div>
        @if($errors->any())<div class="alert alert-danger rounded-4">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label for="name">Name / Contact person</label><input id="name" class="form-control" name="name" value="{{ old('name') }}" autocomplete="name" required></div>
                <div class="col-md-6"><label for="email">Email</label><input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required></div>
                <div class="col-md-6"><label for="phone">Phone</label><input id="phone" class="form-control" name="phone" value="{{ old('phone') }}" autocomplete="tel" required></div>
                <div class="col-md-6"><label for="role">Account type</label><select id="role" class="form-select" name="role" required><option value="customer">Customer</option><option value="farmer" @selected(old('role')==='farmer')>Farmer / Stall</option></select></div>
                <div class="col-12"><label for="address">Address</label><input id="address" class="form-control" name="address" value="{{ old('address') }}" autocomplete="street-address" required></div>
                <div class="col-md-6"><label for="password">Password</label><input id="password" class="form-control" type="password" name="password" autocomplete="new-password" required></div>
                <div class="col-md-6"><label for="password_confirmation">Confirm password</label><input id="password_confirmation" class="form-control" type="password" name="password_confirmation" autocomplete="new-password" required></div>
            </div>
            <button class="btn btn-success w-100 rounded-pill py-3 mt-4" type="submit"><i class="bi bi-person-check me-1"></i>Create account</button>
        </form>
        <div class="auth-divider"><span>Already registered?</span></div>
        <a href="{{ route('login') }}" class="btn btn-outline-dark w-100 rounded-pill py-2">Sign in</a>
        <p class="auth-note">Farmer accounts require admin approval before products can be listed.</p>
    </div>
</div>
@endsection
