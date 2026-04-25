@extends('layouts.app')

@section('page-title', 'Profil Saya')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-id-badge"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Profil Admin</h4>
                    <p>Perbarui identitas, kontak, dan keamanan akun Anda dari satu halaman yang lebih tertata.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Photo Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm text-center h-100 rounded-4 p-3">
                <div class="card-body">
                    <div class="position-relative d-inline-block mb-4">
                        @if($user->foto_profile)
                            <img src="{{ route('storage.profiles', $user->foto_profile) }}" class="avatar-display"
                                 alt="Profile">
                        @else
                            <div class="avatar-placeholder-lg mx-auto">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <label for="foto_profile_upload" class="position-absolute bottom-0 end-0 btn btn-light rounded-circle shadow-sm p-2" style="color: var(--primary-color);">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="foto_profile_upload" name="foto_profile" accept="image/*" class="d-none">
                    </div>
                    
                    <h5 class="fw-bold mb-1 text-dark">{{ $user->name }}</h5>
                    <span class="badge rounded-pill px-3 py-2 mb-3" style="background-color: var(--primary-color)20; color: var(--primary-color);">
                        {{ ucfirst($user->role) }}
                    </span>
                    <p class="text-muted small mb-4">{{ $user->email }}</p>
                    
                    <button class="btn btn-outline-secondary w-100 rounded-3 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-lock me-1"></i> Ubah Password
                    </button>
                </div>
            </div>
        </div>

        <!-- Profile Edit Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-user-edit me-2" style="color: var(--primary-color);"></i>Edit Profil</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                <input type="text" class="form-control rounded-3" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Email</label>
                                <input type="email" class="form-control rounded-3" value="{{ $user->email }}" disabled>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Divisi</label>
                                <input type="text" class="form-control rounded-3" name="divisi" value="{{ old('divisi', $user->divisi) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nomor Telepon</label>
                                <input type="text" class="form-control rounded-3" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Alamat Lengkap</label>
                            <textarea class="form-control rounded-3" name="alamat" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn text-white rounded-3 px-4 py-2 fw-bold" style="background-color: var(--primary-color);">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Change Password Modal --}}
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-lock me-2" style="color: var(--primary-color);"></i>Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Password Saat Ini</label>
                        <input type="password" class="form-control rounded-3" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Password Baru</label>
                        <input type="password" class="form-control rounded-3" name="password_baru" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Konfirmasi Password</label>
                        <input type="password" class="form-control rounded-3" name="konfirmasi_password" required>
                    </div>
                    <button type="submit" class="btn w-100 text-white rounded-3 py-2 fw-bold" style="background-color: var(--primary-color);">
                        <i class="fas fa-key me-1"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

