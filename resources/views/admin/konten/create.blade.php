@extends('layouts.app')

@section('title', 'Tambah Konten Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Konten Baru</h3>
                </div>

                <div class="card-body">
                    <form id="kontenForm" action="{{ route('konten.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="nama_konten">Nama Konten</label>
                            <input type="text" name="nama_konten" id="nama_konten" class="form-control @error('nama_konten') is-invalid @enderror" value="{{ old('nama_konten') }}" required>
                            @error('nama_konten')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tipe">Tipe Konten</label>
                            <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror" required>
                                <option value="">Pilih Tipe</option>
                                <option value="gambar" {{ old('tipe') == 'gambar' ? 'selected' : '' }}>Gambar</option>
                                <option value="file" {{ old('tipe') == 'file' ? 'selected' : '' }}>File (PDF, DOC, dll.)</option>
                                <option value="link" {{ old('tipe') == 'link' ? 'selected' : '' }}>Link Eksternal</option>
                            </select>
                            @error('tipe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div id="fileUploadSection" class="form-group mb-3" style="display: none;">
                            <label for="file_konten">Unggah File (Gambar/Dokumen)</label>
                            <input type="file" name="file_konten" id="file_konten" class="form-control-file @error('file_konten') is-invalid @enderror">
                            <small class="form-text text-muted">Ukuran maksimal 10MB.</small>
                            @error('file_konten')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div id="linkUrlSection" class="form-group mb-3" style="display: none;">
                            <label for="link_url">URL Link</label>
                            <input type="url" name="link_url" id="link_url" class="form-control @error('link_url') is-invalid @enderror" value="{{ old('link_url') }}">
                            @error('link_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Konten</button>
                        <a href="{{ route('konten.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
            linkInput.value = ''; // Clear link URL if switching from link
            fileInput.required = true; // Make file upload required for gambar/file
            linkInput.required = false;
        } else if (selectedTipe === 'link') {
            fileUploadSection.style.display = 'none';
            linkUrlSection.style.display = 'block';
            fileInput.value = ''; // Clear file input if switching to link
            fileInput.required = false;
            linkInput.required = true; // Make link URL required for link
        } else {
            fileUploadSection.style.display = 'none';
            linkUrlSection.style.display = 'none';
            fileInput.value = '';
            linkInput.value = '';
            fileInput.required = false;
            linkInput.required = false;
        }
    }

    // Initial check on page load
    document.addEventListener('DOMContentLoaded', toggleInputSections);
    // Add event listener for changes in the select dropdown
    tipeSelect.addEventListener('change', toggleInputSections);
</script>
@endsection
