@extends('layouts.app')

@section('page-title', 'Edit Konten')

@section('content')
<div class="main-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-edit me-2 text-primary"></i>Edit Konten
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('konten.update', $konten->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nama_konten" class="form-label fw-semibold">Nama Konten <span class="text-danger">*</span></label>
                            <input type="text" name="nama_konten" id="nama_konten" 
                                   class="form-control @error('nama_konten') is-invalid @enderror" 
                                   value="{{ old('nama_konten', $konten->nama_konten) }}" required 
                                   placeholder="Masukkan nama konten">
                            @error('nama_konten')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      placeholder="Jelaskan konten ini">{{ old('deskripsi', $konten->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="tipe" class="form-label fw-semibold">Tipe Konten <span class="text-danger">*</span></label>
                                <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="gambar" {{ old('tipe', $konten->tipe) == 'gambar' ? 'selected' : '' }}>Gambar</option>
                                    <option value="file" {{ old('tipe', $konten->tipe) == 'file' ? 'selected' : '' }}>File (PDF, DOC)</option>
                                    <option value="link" {{ old('tipe', $konten->tipe) == 'link' ? 'selected' : '' }}>Link Eksternal</option>
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="imageUploadSection" class="mb-4" style="display: none;">
                            <label for="file_konten" class="form-label fw-semibold">Ganti Gambar (Opsional)</label>
                            <input type="file" name="gambar_konten" id="gambar_konten" 
                                   class="form-control @error('gambar_konten') is-invalid @enderror"
                                   accept="image/*">
                            <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengganti gambar.</small>
                            @if($konten->file_path && $konten->tipe === 'gambar')
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-image me-1"></i> Gambar saat ini: {{ basename($konten->file_path) }}
                                </small>
                            @endif
                            @error('gambar_konten')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="documentUploadSection" class="mb-4" style="display: none;">
                            <label for="file_konten_doc" class="form-label fw-semibold">Ganti File (Opsional)</label>
                            <input type="file" name="dokumen_konten" id="dokumen_konten" 
                                   class="form-control @error('dokumen_konten') is-invalid @enderror"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt">
                            <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengganti file.</small>
                            @if($konten->file_path && $konten->tipe === 'file')
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-file me-1"></i> File saat ini: {{ basename($konten->file_path) }}
                                </small>
                            @endif
                            @error('dokumen_konten')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="linkUrlSection" class="mb-4" style="display: none;">
                            <label for="link_url" class="form-label fw-semibold">URL Link <span class="text-danger">*</span></label>
                            <input type="url" name="link_url" id="link_url" 
                                   class="form-control @error('link_url') is-invalid @enderror" 
                                   value="{{ old('link_url', $konten->link_url) }}" placeholder="https://example.com">
                            @error('link_url')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('konten.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <div>
                                <button type="reset" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-redo me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Update Konten
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
            docFileInput.value = '';
            linkInput.value = '';
        } else if (selectedTipe === 'file') {
            documentUploadSection.style.display = 'block';
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
