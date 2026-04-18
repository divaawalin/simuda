@extends('layouts.app')

@section('content')
<div class="main-container">
    <!-- Breadcrumb-like navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('kegiatan.index') }}">Daftar Kegiatan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Kegiatan</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h6 class="m-0 fw-bold">
                <i class="fas fa-calendar-edit me-2 text-primary"></i>Edit Kegiatan
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="nama_kegiatan" class="form-label fw-semibold">
                                Nama Kegiatan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" 
                                   class="form-control @error('nama_kegiatan') is-invalid @enderror" 
                                   value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required 
                                   placeholder="Masukkan nama kegiatan">
                            @error('nama_kegiatan')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="deskripsi" class="form-label fw-semibold">
                                Deskripsi Kegiatan
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      placeholder="Jelaskan detail kegiatan">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Date & Time Row -->
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="tanggal" class="form-label fw-semibold">
                                Tanggal <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal" 
                                   class="form-control @error('tanggal') is-invalid @enderror" 
                                   value="{{ old('tanggal', $kegiatan->tanggal) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="waktu_mulai" class="form-label fw-semibold">
                                Waktu Mulai <span class="text-danger">*</span>
                            </label>
                            <input type="time" name="waktu_mulai" id="waktu_mulai" 
                                   class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                   value="{{ old('waktu_mulai', substr($kegiatan->waktu_mulai, 0, 5)) }}" required>
                            @error('waktu_mulai')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="waktu_selesai" class="form-label fw-semibold">
                                Waktu Selesai <span class="text-danger">*</span>
                            </label>
                            <input type="time" name="waktu_selesai" id="waktu_selesai" 
                                   class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                   value="{{ old('waktu_selesai', substr($kegiatan->waktu_selesai, 0, 5)) }}" required>
                            @error('waktu_selesai')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="lokasi" class="form-label fw-semibold">
                                Lokasi <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="lokasi" id="lokasi" 
                                   class="form-control @error('lokasi') is-invalid @enderror" 
                                   value="{{ old('lokasi', $kegiatan->lokasi) }}" required 
                                   placeholder="Contoh: Aula Utama, Lantai 2">
                            @error('lokasi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label fw-semibold">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select name="status" id="status" 
                                    class="form-control @error('status') is-invalid @enderror" required>
                                <option value="draft" {{ old('status', $kegiatan->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="aktif" {{ old('status', $kegiatan->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ old('status', $kegiatan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <div>
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-redo me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Update Kegiatan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
