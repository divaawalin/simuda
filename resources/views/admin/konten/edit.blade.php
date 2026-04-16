@extends('layouts.app')

@section('title', 'Edit Konten')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Konten: {{ $konten->nama_konten }}</h3>
                </div>

                <div class="card-body">
                    <form id="kontenForm" action="{{ route('konten.update', $konten->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="nama_konten">Nama Konten</label>
                            <input type="text" name="nama_konten" id="nama_konten" class="form-control @error('nama_konten') is-invalid @enderror" value="{{ old('nama_konten', $konten->nama_konten) }}" required>
                            @error('nama_konten')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $konten->deskripsi) }}</textarea>
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
                                <option value="gambar" {{ old('tipe', $konten->tipe) == 'gambar' ? 'selected' : '' }}>Gambar</option>
                                <option value="file" {{ old('tipe', $konten->tipe) == 'file' ? 'selected' : '' }}>File (PDF, DOC, dll.)</option>
                                <option value="link" {{ old('tipe', $konten->tipe) == 'link' ? 'selected' : '' }}>Link Eksternal</option>
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
                            <small class="form-text text-muted">Unggah file baru untuk mengganti yang lama. Ukuran maksimal 10MB.</small>
                            @if ($konten->file_path)
                                <p>File saat ini: <a href="{{ Storage::disk('konten')->url($konten->file_path) }}" target="_blank">{{ $konten->file_path }}</a></p>
                            @endif
                            @error('file_konten')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div id="linkUrlSection" class="form-group mb-3" style="display: none;">
                            <label for="link_url">URL Link</label>
                            <input type="url" name="link_url" id="link_url" class="form-control @error('link_url') is-invalid @enderror" value="{{ old('link_url', $konten->link_url) }}">
                            @error('link_url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Perbarui Konten</button>
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
            // Note: fileInput.required might be too strict if user doesn't intend to change the file.
            // The controller validation handles this more gracefully by checking for file presence only if tipe requires it.
            // However, we can make it required if the user selects gambar/file type, but they can choose to NOT upload a new file to keep the old one.
            // The current controller logic: if tipe is gambar/file and new file uploaded, delete old, save new. If no new file, keep old file_path.
            // For simplicity and based on original create.blade. Need to ensure the validation rule in controller is correct.
            // The controller correctly uses 'nullable' for file_konten in update, and 'required_if' in store.
        } else if (selectedTipe === 'link') {
            fileUploadSection.style.display = 'none';
            linkUrlSection.style.display = 'block';
            fileInput.value = ''; // Clear file input if switching to link
        } else {
            fileUploadSection.style.display = 'none';
            linkUrlSection.style.display = 'none';
            fileInput.value = '';
            linkInput.value = '';
        }
    }

    // Initial check on page load
    document.addEventListener('DOMContentLoaded', toggleInputSections);
    // Add event listener for changes in the select dropdown
    tipeSelect.addEventListener('change', toggleInputSections);

    // Trigger the toggle function on page load to set initial state
    toggleInputSections();
</script>
@endsection
