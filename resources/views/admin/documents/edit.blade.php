@extends('layouts.app')

@section('page-title', 'Edit Dokumen')

@section('content')
<div class="container-fluid px-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <span><i class="fas fa-edit me-2"></i>Edit Dokumen</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Dokumen</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $document->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $document->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="file" class="form-label">Ganti File (Opsional)</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                             <div class="form-text">Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX (Maks. 10MB)<br>File saat ini: <code>{{ basename($document->file_path) }}</code> ({{ number_format($document->file_size / 1024, 2) }} KB)</div>
                            <div class="form-text">File saat ini: {{ basename($document->file_path) }}</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update
                            </button>
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
