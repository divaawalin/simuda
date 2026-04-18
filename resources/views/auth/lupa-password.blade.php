@extends('layouts.auth')

@section('title', 'Lupa Password')
@section('eyebrow', 'Pemulihan')
@section('auth_icon', 'fas fa-key')
@section('heading', 'Lupa Password')
@section('subtitle', 'Masukkan email akun Anda. Sistem akan mengirimkan tautan reset password agar Anda bisa masuk kembali.')

@section('auth_content')
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-circle-check me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-circle-exclamation me-2"></i>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/lupa-password') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <div class="input-shell">
                <span class="field-icon"><i class="fas fa-envelope-open-text"></i></span>
                <input id="email" type="email" class="form-control with-icon @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@contoh.com">
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-auth">
            Kirim Link Reset <i class="fas fa-paper-plane ms-2"></i>
        </button>

        <div class="auth-links">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke login
            </a>
        </div>
    </form>
@endsection
