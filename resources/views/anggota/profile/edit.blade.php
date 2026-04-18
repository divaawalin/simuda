@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="row g-4">
        <!-- Profile Photo Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body p-4">
                    <div class="profile-photo-container mb-4">
                        @if($user->foto_profile)
                            <img src="{{ route('storage.profiles', $user->foto_profile) }}" class="rounded-3 shadow" 
                                 alt="Profile" style="width: 160px; height: 160px; object-fit: cover; border: 4px solid var(--primary-color);">
                        @else
                            <div class="bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 160px; height: 160px; color: var(--primary-color); font-size: 3.5rem; font-weight: 700;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                            {{ ucfirst($user->role) }}
                        </span>
                    </p>
                    <small class="text-muted d-block mb-3">{{ $user->email }}</small>
                    
                    <div class="d-grid gap-2">
                        <label for="foto_profile_upload" class="btn btn-outline-primary btn-sm rounded-3 shadow-sm cursor-pointer">
                            <i class="fas fa-camera me-1"></i> Ubah Foto Profil
                        </label>
                        <input type="file" id="foto_profile_upload" name="foto_profile" accept="image/*" class="d-none" onchange="previewImage(event)">
                        
                        <button class="btn btn-outline-secondary btn-sm rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-lock me-1"></i> Ubah Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Edit Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-user-edit me-2 text-primary"></i>Edit Profil
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('anggota.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email <span class="text-muted">(Tidak dapat diubah)</span></label>
                                <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="divisi" class="form-label fw-semibold">Divisi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('divisi') is-invalid @enderror" 
                                       id="divisi" name="divisi" value="{{ old('divisi', $user->divisi) }}" required>
                                @error('divisi')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="no_telp" class="form-label fw-semibold">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" 
                                       id="no_telp" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" required>
                                @error('no_telp')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="foto_profile" class="form-label fw-semibold">Foto Profil (Opsional)</label>
                            <input class="form-control @error('foto_profile') is-invalid @enderror" 
                                   type="file" id="foto_profile" name="foto_profile" accept="image/*">
                            @if($user->foto_profile)
                                <small class="text-muted mt-2 d-block">Foto saat ini: {{ $user->foto_profile }}</small>
                            @endif
                            @error('foto_profile')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end pt-3 border-top">
                            <button type="submit" class="btn btn-success px-4 py-2">
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
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header bg-primary text-white border-0 p-4">
                <h5 class="modal-title fw-bold" id="changePasswordModalLabel">
                    <i class="fas fa-lock me-2"></i>Ubah Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('anggota.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                  style="cursor: pointer;" onclick="togglePassword('current_password')">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_baru" class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="password" class="form-control" id="password_baru" name="password_baru" required>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                  style="cursor: pointer;" onclick="togglePassword('password_baru')">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="konfirmasi_password" class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" required>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                  style="cursor: pointer;" onclick="togglePassword('konfirmasi_password')">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-3 py-2 fw-bold shadow-sm">
                            <i class="fas fa-key me-1"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.querySelector('.profile-photo-container img');
            if (preview) {
                preview.src = reader.result;
            } else {
                const imgPlaceholder = document.createElement('img');
                imgPlaceholder.src = reader.result;
                imgPlaceholder.classList.add('rounded-3', 'shadow');
                imgPlaceholder.style.width = '160px';
                imgPlaceholder.style.height = '160px';
                imgPlaceholder.style.objectFit = 'cover';
                imgPlaceholder.style.border = '4px solid var(--primary-color)';
                document.querySelector('.profile-photo-container').innerHTML = '';
                document.querySelector('.profile-photo-container').appendChild(imgPlaceholder);
            }
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
