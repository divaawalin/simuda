@extends('layouts.auth')

@section('title', 'Reset Password')
@section('eyebrow', 'Reset Password')
@section('auth_icon', 'fas fa-unlock-keyhole')
@section('heading', 'Buat Password Baru')
@section('subtitle', 'Masukkan password baru yang kuat dan mudah Anda ingat untuk mengaktifkan kembali akses ke sistem.')

@section('auth_content')
    <div class="text-center">
        <img src="{{ asset('assets/logo-generus.png') }}" alt="Logo Generus" class="img-fluid" style="max-height: 180px;">
    </div>
    <form action="{{ url('/reset-password') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="password" class="form-label">Password Baru</label>
            <div class="input-shell">
                <span class="field-icon"><i class="fas fa-lock"></i></span>
                <input id="password" type="password" class="form-control with-icon @error('password') is-invalid @enderror" name="password" required placeholder="Masukkan password baru">
                <span class="password-toggle" onclick="togglePassword('password')">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-shell">
                <span class="field-icon"><i class="fas fa-shield-heart"></i></span>
                <input id="password_confirmation" type="password" class="form-control with-icon" name="password_confirmation" required placeholder="Ulangi password baru">
                <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-auth">
            Simpan Password Baru <i class="fas fa-save ms-2"></i>
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
