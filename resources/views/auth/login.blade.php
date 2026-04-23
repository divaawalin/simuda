@extends('layouts.auth')

@section('auth_content')
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-circle-exclamation me-2"></i>{{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-circle-check me-2"></i>{{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <div class="input-shell">
                <span class="field-icon"><i class="fas fa-envelope"></i></span>
                <input id="email" type="email" class="form-control with-icon @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@contoh.com">
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-shell">
                <span class="field-icon"><i class="fas fa-lock"></i></span>
                <input id="password" type="password" class="form-control with-icon @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan password Anda">
                <span class="password-toggle" onclick="togglePassword('password')">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Tetap masuk di perangkat ini</label>
            </div>
        </div>

        <button type="submit" class="btn btn-auth">
            Masuk ke Sistem <i class="fas fa-arrow-right ms-2"></i>
        </button>

        <div class="auth-links">
            <a href="{{ route('password.request') }}">
                <i class="fas fa-key me-1"></i>Lupa password?
            </a>
        </div>
    </form>
@endsection
