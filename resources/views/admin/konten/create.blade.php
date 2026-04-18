@extends('layouts.app')

@section('page-title', 'Tambah Konten Baru')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm p-4 mb-4 rounded-4" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
        <div class="d-flex align-items-center">
            <div class="text-white p-3 rounded-4 me-4" style="background-color: rgba(255, 255, 255, 0.15);">
                <i class="fas fa-plus fa-2x"></i>
            </div>
            <div>
                <h4 class="fw-bold text-white mb-1">Tambah Konten Baru</h4>
                <p class="text-white-50 small mb-0">Unggah atau tautkan konten baru untuk organisasi Anda.</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">
            <form action="{{ route('konten.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Nama Konten <span class="text-danger">*</span></label>
                        <input type="text" name="nama_konten" id="nama_konten" 
                               class="form-control rounded-3 @error('nama_konten') is-invalid @enderror" 
                               value="{{ old('nama_konten') }}" required 
                               placeholder="Contoh: Laporan Tahunan 2023">
                        @error('nama_konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Tipe Konten <span class="text-danger">*</span></label>
                        <select name="tipe" id="tipe" class="form-select rounded-3 @error('tipe') is-invalid @enderror" required>
                            <option value="" disabled {{ old('tipe') ? '' : 'selected' }}>Pilih Tipe Konten</option>
                            <option value="gambar" {{ old('tipe') == 'gambar' ? 'selected' : '' }}>Gambar</option>
                            <option value="file" {{ old('tipe') == 'file' ? 'selected' : '' }}>File (PDF, DOC, dll.)</option>
                            <option value="link" {{ old('tipe') == 'link' ? 'selected' : '' }}>Link Eksternal</option>
                        </select>
                        @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" 
                              class="form-control rounded-3 @error('deskripsi') is-invalid @enderror" 
                              placeholder="Deskripsikan konten ini secara singkat">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Conditional Input Fields Based on Type -->
                <div id="conditionalInputContainer">
                    <!-- For Gambar (Image) -->
                    <div id="imageUploadSection" class="mb-4" style="display: none;">
                        <label for="file_konten" class="form-label small fw-bold text-muted">Unggah Gambar <span class="text-danger">*</span></label>
                        <input type="file" name="gambar_konten" id="gambar_konten" 
                               class="form-control rounded-3 @error('gambar_konten') is-invalid @enderror"
                               accept="image/*">
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i> Format: JPG, JPEG, PNG, GIF. Maksimal 10MB.
                        </small>
                        @error('gambar_konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- For File (PDF, DOC, dll) -->
                    <div id="documentUploadSection" class="mb-4" style="display: none;">
                        <label for="file_konten_doc" class="form-label small fw-bold text-muted">Unggah File <span class="text-danger">*</span></label>
                        <input type="file" name="dokumen_konten" id="dokumen_konten" 
                               class="form-control rounded-3 @error('dokumen_konten') is-invalid @enderror"
                               accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt">
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle me-1"></i> Format: PDF, DOC, DOCX, PPT, XLS, TXT. Maksimal 10MB.
                        </small>
                        @error('dokumen_konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- For Link -->
                    <div id="linkUrlSection" class="mb-4" style="display: none;">
                        <label for="link_url" class="form-label small fw-bold text-muted">URL Link <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3" style="border-right: none;">
                                <i class="fas fa-link text-muted"></i>
                            </span>
                            <input type="url" name="link_url" id="link_url" 
                                   class="form-control rounded-3 @error('link_url') is-invalid @enderror border-start-0"
                                   value="{{ old('link_url') }}" 
                                   placeholder="https://example.com/dokumen"
                                   style="border-left: none;">
                        </div>
                        @error('link_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                    <a href="{{ route('konten.index') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2">
                        <i class="fas fa-arrow-left me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn text-white rounded-3 px-4 py-2 fw-bold" style="background-color: var(--primary-color);">
                        <i class="fas fa-save me-1"></i> Simpan Konten
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tipeSelect = document.getElementById('tipe');
    const imageUploadSection = document.getElementById('imageUploadSection');
    const documentUploadSection = document.getElementById('documentUploadSection');
    const linkUrlSection = document.getElementById('linkUrlSection');
    const imageFileInput = document.getElementById('gambar_konten');
    const docFileInput = document.getElementById('dokumen_konten');
    const linkInput = document.getElementById('link_url');

    if (!tipeSelect) {
        return;
    }

    function toggleInputSections() {
        const selectedTipe = tipeSelect.value;

        imageUploadSection.style.display = 'none';
        documentUploadSection.style.display = 'none';
        linkUrlSection.style.display = 'none';

        imageFileInput.required = false;
        docFileInput.required = false;
        linkInput.required = false;

        if (selectedTipe === 'gambar') {
            imageUploadSection.style.display = 'block';
            imageFileInput.required = true;
            docFileInput.value = '';
            linkInput.value = '';
        } else if (selectedTipe === 'file') {
            documentUploadSection.style.display = 'block';
            docFileInput.required = true;
            imageFileInput.value = '';
            linkInput.value = '';
        } else if (selectedTipe === 'link') {
            linkUrlSection.style.display = 'block';
            linkInput.required = true;
            imageFileInput.value = '';
            docFileInput.value = '';
        } else {
            imageFileInput.value = '';
            docFileInput.value = '';
            linkInput.value = '';
        }
    }

    toggleInputSections();
    tipeSelect.addEventListener('change', toggleInputSections);
});
</script>
@endpush
