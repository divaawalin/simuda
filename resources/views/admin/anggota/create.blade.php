@extends('layouts.app')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('anggota.index') }}" style="text-decoration: none; color: #3498db;">&larr; Kembali ke Daftar Anggota</a>
</div>

<div class="card">
    <h3>Tambah Anggota Baru</h3>
    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

    <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="divisi">Divisi / Jabatan</label>
                <input type="text" name="divisi" id="divisi" class="form-control @error('divisi') is-invalid @enderror" value="{{ old('divisi') }}" required>
                @error('divisi')
                    <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_telp">No. Telepon</label>
                <input type="text" name="no_telp" id="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp') }}" required>
                @error('no_telp')
                    <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="position-relative">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password')">
                        <i class="fas fa-eye text-muted"></i>
                    </span>
                </div>
                @error('password')
                    <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="foto_profile">Foto Profile</label>
                <input type="file" name="foto_profile" id="foto_profile" class="form-control @error('foto_profile') is-invalid @enderror">
                <small style="color: #7f8c8d;">Format: jpg, jpeg, png. Max: 2MB</small>
                @error('foto_profile')
                    <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat') }}</textarea>
            @error('alamat')
                <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Simpan Anggota</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</div>
@endsection
