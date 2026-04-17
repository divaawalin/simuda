@extends('layouts.app')

@section('page-title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm text-center h-100">
            <div class="card-body p-4">
                <div class="profile-photo-container mb-3">
                    @if($user->foto_profile)
                        <img src="{{ route('storage.profiles', $user->foto_profile) }}" class="rounded-circle img-fluid" alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold mx-auto" style="width: 150px; height: 150px; font-size: 3rem;">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-1"><span class="badge bg-info-subtle text-info rounded-pill">{{ ucfirst($user->role) }}</span></p>
                <small class="text-muted d-block mb-3">{{ $user->email }}</small>
                
                <label for="foto_profile_upload" class="btn btn-primary rounded-3 btn-sm mb-1 shadow-sm cursor-pointer">
                    <i class="fas fa-camera me-1"></i> Ubah Foto Profil
                </label>
                <input type="file" id="foto_profile_upload" name="foto_profile" accept="image/*" class="d-none" onchange="previewImage(event)">

                <button class="btn btn-outline-secondary rounded-3 btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="fas fa-lock me-1"></i> Ubah Password
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header">
                <h6 class="m-0 fw-bold text-primary"><i class="fas fa-user-edit me-2"></i>Edit Profil</h6>
            </div>
            <div class="card-body">
                <form id="profileForm" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control rounded-3" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control rounded-3" id="email" name="email" value="{{ old('email', $user->email) }}" required disabled>
                            <small class="form-text text-muted">Email tidak dapat diubah.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="divisi" class="form-label">Divisi</label>
                            <input type="text" class="form-control rounded-3" id="divisi" name="divisi" value="{{ old('divisi', $user->divisi) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="no_telp" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control rounded-3" id="no_telp" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control rounded-3" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="foto_profile_upload" class="form-label">Foto Profil (Opsional)</label>
                        <input class="form-control rounded-3" type="file" id="foto_profile_upload" name="foto_profile" accept="image/*">
                        @if($user->foto_profile)
                            <small class="text-muted mt-2 d-block">Foto saat ini: {{ $user->foto_profile }}</small>
                        @endif
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary rounded-3 shadow-sm px-4 py-2">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Change Password Modal --}}
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-header bg-primary text-white border-0 p-4">
                <h5 class="modal-title fw-bold" id="changePasswordModalLabel"><i class="fas fa-lock me-2"></i>Ubah Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control rounded-3" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_baru" class="form-label">Password Baru</label>
                        <input type="password" class="form-control rounded-3" id="password_baru" name="password_baru" required>
                    </div>
                    <div class="mb-4">
                        <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control rounded-3" id="konfirmasi_password" name="konfirmasi_password" required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-3 py-2 fw-bold shadow-sm">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.querySelector('.profile-photo-container img');
        if (preview) {
            preview.src = reader.result;
            preview.style.width = '150px';
            preview.style.height = '150px';
            preview.style.objectFit = 'cover';
        } else {
            // Fallback if img tag doesn't exist, create one or log error
            const imgPlaceholder = document.createElement('img');
            imgPlaceholder.src = reader.result;
            imgPlaceholder.classList.add('rounded-circle', 'img-fluid');
            imgPlaceholder.style.width = '150px';
            imgPlaceholder.style.height = '150px';
            imgPlaceholder.style.objectFit = 'cover';
            document.querySelector('.profile-photo-container').innerHTML = ''; // Clear previous placeholder
            document.querySelector('.profile-photo-container').appendChild(imgPlaceholder);
        }
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Initialize existing image or placeholder if needed on load
document.addEventListener('DOMContentLoaded', function() {
    const currentProfilePic = document.querySelector('.profile-photo-container img');
    if (!currentProfilePic) {
        const userInitial = '{{ substr($user->name, 0, 1) }}';
        document.querySelector('.profile-photo-container').innerHTML = `
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold mx-auto" style="width: 150px; height: 150px; font-size: 3rem;">
                ${userInitial}
            </div>
        `;
    }
});
</script>
@endpush
