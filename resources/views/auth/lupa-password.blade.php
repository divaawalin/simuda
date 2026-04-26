@extends('layouts.auth')

@section('title', 'Lupa Password')
@section('eyebrow', 'Pemulihan')
@section('auth_icon', 'fas fa-key')
@section('heading', 'Lupa Password')
@section('subtitle', 'Masukkan email akun Anda untuk verifikasi.')

@section('auth_content')
    <div class="text-center mb-4">
        <img src="{{ asset('assets/logo-generus.png') }}" alt="Logo Generus" class="img-fluid" style="max-height: 120px;">
    </div>
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
            Verifikasi Email <i class="fas fa-paper-plane ms-2"></i>
        </button>

        <div class="auth-links">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke login
            </a>
        </div>
    </form>
@endsection

@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        html: '{!! implode("<br>", $errors->all()) !!}',
        confirmButtonColor: '#048e8e',
        confirmButtonText: 'Mengerti'
    });
</script>
@endif
