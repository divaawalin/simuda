@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Profil & Kata Sandi</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Profile Edit Form --}}
    <div class="card mb-4">
        <div class="card-header">Informasi Profil</div>
        <div class="card-body">
            <form action="{{ route('anggota.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Nama Lengkap</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="divisi" class="col-md-4 col-form-label text-md-end">Divisi</label>
                    <div class="col-md-6">
                        <input id="divisi" type="text" class="form-control @error('divisi') is-invalid @enderror" name="divisi" value="{{ old('divisi', $user->divisi) }}" autocomplete="divisi">
                        @error('divisi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="no_telp" class="col-md-4 col-form-label text-md-end">Nomor Telepon</label>
                    <div class="col-md-6">
                        <input id="no_telp" type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" autocomplete="no_telp">
                        @error('no_telp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="alamat" class="col-md-4 col-form-label text-md-end">Alamat</label>
                    <div class="col-md-6">
                        <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="foto_profile" class="col-md-4 col-form-label text-md-end">Foto Profil</label>
                    <div class="col-md-6">
                        <input id="foto_profile" type="file" class="form-control @error('foto_profile') is-invalid @enderror" name="foto_profile" accept="image/*">
                        @if ($user->foto_profile)
                            {{-- Assuming foto_profile stores the path relative to the 'profiles' disk, specifically in 'uploads' subdirectory --}}
                            <small class="form-text text-muted">Foto profil saat ini: <a href="{{ asset('storage/uploads/' . $user->foto_profile) }}" target="_blank">{{ basename($user->foto_profile) }}</a></small>
                        @endif
                        @error('foto_profile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan Profil
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Password Update Form --}}
    <div class="card">
        <div class="card-header">Ubah Kata Sandi</div>
        <div class="card-body">
            <form action="{{ route('anggota.profile.updatePassword') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <label for="current_password" class="col-md-4 col-form-label text-md-end">Kata Sandi Saat Ini</label>
                    <div class="col-md-6">
                        <div class="position-relative">
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current-password">
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('current_password')">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">Kata Sandi Baru</label>
                    <div class="col-md-6">
                        <div class="position-relative">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password')">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">Konfirmasi Kata Sandi Baru</label>
                    <div class="col-md-6">
                        <div class="position-relative">
                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-success">
                            Ubah Kata Sandi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
