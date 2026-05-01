@extends('layouts.auth')

@use('Illuminate\Support\Facades\Route')

@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        @if ($errors->any())
            <div class="error-message">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ __('Authentication protocol failed.') }}
            </div>
        @endif

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Operative Email') }}</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope"></i>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@domain.com" />
            </div>
            @error('email')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="label text-muted small text-uppercase fw-bold mb-2 d-block">{{ __('Security Key') }}</label>
            <div class="input-wrapper">
                <i class="fas fa-lock"></i>
                <input id="password" class="form-control"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="••••••••" />
            </div>
            @error('password')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me & Reset -->
        <div class="auth-options">
            <label for="remember_me" class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>{{ __('Keep Session Active') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    {{ __('Recover Key?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="btn-auth">
            <i class="fas fa-sign-in-alt"></i>
            {{ __('INITIALIZE UPLINK') }}
        </button>
    </form>
@endsection
