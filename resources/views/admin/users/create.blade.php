@extends('layouts.app')

@section('page-title', 'Tambah User Admin')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon"><i class="fas fa-user-shield"></i></div>
                <div>
                    <h4 class="fw-bold">Tambah User Admin</h4>
                    <p>Buat akun admin, sekretaris, atau ketua dengan profil dan role yang tepat.</p>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h6 class="m-0 fw-bold">
                <i class="fas fa-user-plus me-2 text-primary"></i>Tambah User Admin Baru
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                    <!-- Profile Photo Upload -->
                    <div class="col-12 text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img id="photo-preview" src="#" alt="Preview" 
                                 class="rounded-3 shadow-sm mb-2" 
                                 style="width: 120px; height: 120px; object-fit: cover; display: none; border: 3px solid var(--primary-color);">
                            <div id="photo-placeholder" class="bg-primary-subtle rounded-3 d-flex align-items-center justify-content-center" 
                                 style="width: 120px; height: 120px; margin: 0 auto; color: var(--primary-color); font-size: 2.5rem; font-weight: 700;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label for="foto_profile" class="btn btn-outline-primary btn-sm rounded-3">
                                <i class="fas fa-camera me-1"></i> Upload Foto
                            </label>
                            <input type="file" name="foto_profile" id="foto_profile" class="d-none" accept="image/*" onchange="previewImage(this)">
                            <small class="d-block mt-2 text-muted">Format: JPG, PNG, JPEG (Max 2MB)</small>
                        </div>
                        @error('foto_profile')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Personal Information -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required 
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required 
                                   placeholder="name@example.com">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="divisi" class="form-label fw-semibold">
                                Divisi / Jabatan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="divisi" id="divisi" 
                                   class="form-control @error('divisi') is-invalid @enderror" 
                                   value="{{ old('divisi') }}" required 
                                   placeholder="Contoh: Divisi IT">
                            @error('divisi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="no_telp" class="form-label fw-semibold">
                                No. Telepon <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="no_telp" id="no_telp" 
                                   class="form-control @error('no_telp') is-invalid @enderror" 
                                   value="{{ old('no_telp') }}" required 
                                   placeholder="08xxxxxxxxxx">
                            @error('no_telp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Role & Password Section -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="role" class="form-label fw-semibold">
                                Role <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="role" 
                                    class="form-control @error('role') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="sekretaris" {{ old('role') == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                <option value="ketua" {{ old('role') == 'ketua' ? 'selected' : '' }}>Ketua</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <input type="password" name="password" id="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       required placeholder="Masukkan password">
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                      style="cursor: pointer;" onclick="togglePassword('password')"
                                      title="Tampilkan/Sembunyikan password">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-control" required 
                                       placeholder="Ulangi password">
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                      style="cursor: pointer;" onclick="togglePassword('password_confirmation')"
                                      title="Tampilkan/Sembunyikan password">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                            </div>
                            <small class="text-muted" id="password-match" style="font-size: 0.85rem; display: none;"></small>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="alamat" class="form-label fw-semibold">
                        Alamat Lengkap <span class="text-danger">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="3" 
                              class="form-control @error('alamat') is-invalid @enderror" 
                              required placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <div>
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-redo me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Simpan User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('photo-preview');
        const placeholder = document.getElementById('photo-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Password match validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    const matchMsg = document.getElementById('password-match');

    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            matchMsg.textContent = 'Password tidak cocok';
            matchMsg.className = 'text-danger';
            matchMsg.style.display = 'block';
        } else {
            matchMsg.textContent = 'Password cocok';
            matchMsg.className = 'text-success';
            matchMsg.style.display = 'block';
        }
    }

    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);
</script>
@endpush
