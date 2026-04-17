@extends('layouts.app')

@section('content')
<div class="mb-3">
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <h2>Edit User Admin</h2>
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div style="color: red; font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div style="color: red; font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="divisi">Divisi / Jabatan</label>
            <input type="text" name="divisi" id="divisi" class="form-control @error('divisi') is-invalid @enderror" value="{{ old('divisi', $user->divisi) }}" required>
            @error('divisi')
                <div style="color: red; font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="no_telp">No. Telepon</label>
            <input type="text" name="no_telp" id="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $user->no_telp) }}" required>
            @error('no_telp')
                <div style="color: red; font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="sekretaris" {{ old('role', $user->role) == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                <option value="ketua" {{ old('role', $user->role) == 'ketua' ? 'selected' : '' }}>Ketua</option>
            </select>
            @error('role')
                <div style="color: red; font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat')
                <div style="color: red; font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
            <div class="position-relative">
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password')">
                    <i class="fas fa-eye text-muted"></i>
                </span>
            </div>
            @error('password')
                <div style="color: red; font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <div class="position-relative">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password_confirmation')">
                    <i class="fas fa-eye text-muted"></i>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label for="foto_profile">Foto Profile</label>
            @if($user->foto_profile)
                <div class="mb-2">
                    <img src="{{ route('storage.profiles', $user->foto_profile) }}" alt="{{ $user->name }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                </div>
            @endif
            <input type="file" name="foto_profile" id="foto_profile" class="form-control @error('foto_profile') is-invalid @enderror">
            @error('foto_profile')
                <div style="color: red; font-size: 12px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Update User</button>
        </div>
    </form>
</div>
@endsection
