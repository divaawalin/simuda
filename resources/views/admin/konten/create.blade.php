@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Tambah Konten Baru
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('konten.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="nama_konten" class="form-label fw-semibold">Nama Konten <span class="text-danger">*</span></label>
                            <input type="text" name="nama_konten" id="nama_konten" 
                                   class="form-control @error('nama_konten') is-invalid @enderror" 
                                   value="{{ old('nama_konten') }}" required 
                                   placeholder="Masukkan nama konten">
                            @error('nama_konten')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      placeholder="Jelaskan konten ini">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="tipe" class="form-label fw-semibold">Tipe Konten <span class="text-danger">*</span></label>
                                <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="gambar" {{ old('tipe') == 'gambar' ? 'selected' : '' }}>Gambar</option>
                                    <option value="file" {{ old('tipe') == 'file' ? 'selected' : '' }}>File (PDF, DOC)</option>
                                    <option value="link" {{ old('tipe') == 'link' ? 'selected' : '' }}>Link Eksternal</option>
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="fileUploadSection" class="mb-4" style="display: none;">
                            <label for="file_konten" class="form-label fw-semibold">Unggah File (Gambar/Dokumen) <span class="text-danger">*</span></label>
                            <input type="file" name="file_konten" id="file_konten" class="form-control @error('file_konten') is-invalid @enderror">
                            <small class="text-muted d-block mt-1">Ukuran maksimal 10MB.</small>
                            @error('file_konten')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="linkUrlSection" class="mb-4" style="display: none;">
                            <label for="link_url" class="form-label fw-semibold">URL Link <span class="text-danger">*</span></label>
                            <input type="url" name="link_url" id="link_url" class="form-control @error('link_url') is-invalid @enderror" 
                                   value="{{ old('link_url') }}" placeholder="https://example.com">
                            @error('link_url')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('konten.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Simpan Konten
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const tipeSelect = document.getElementById('tipe');
    const fileUploadSection = document.getElementById('fileUploadSection');
    const linkUrlSection = document.getElementById('linkUrlSection');
    const fileInput = document.getElementById('file_konten');
    const linkInput = document.getElementById('link_url');

    function toggleInputSections() {
        const selectedTipe = tipeSelect.value;

        if (selectedTipe === 'gambar' || selectedTipe === 'file') {
            fileUploadSection.style.display = 'block';
            linkUrlSection.style.display = 'none';
            linkInput.value = '';
            fileInput.required = true;
            linkInput.required = false;
        } else if (selectedTipe === 'link') {
            fileUploadSection.style.display = 'none';
            linkUrlSection.style.display = 'block';
            fileInput.value = '';
            fileInput.required = false;
            linkInput.required = true;
        } else {
            fileUploadSection.style.display = 'none';
            linkUrlSection.style.display = 'none';
            fileInput.value = '';
            linkInput.value = '';
            fileInput.required = false;
            linkInput.required = false;
        }
    }

    document.addEventListener('DOMContentLoaded', toggleInputSections);
    tipeSelect.addEventListener('change', toggleInputSections);
</script>
@endsection
