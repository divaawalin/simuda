@extends('layouts.app')

@section('page-title', 'Tambah Kegiatan')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon"><i class="fas fa-calendar-plus"></i></div>
                <div>
                    <h4 class="fw-bold">Tambah Kegiatan Baru</h4>
                    <p>Susun agenda organisasi dengan detail waktu, lokasi, dan status pelaksanaan.</p>
                </div>
            </div>
            <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-light px-4"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h6 class="m-0 fw-bold">
                <i class="fas fa-calendar-plus me-2 text-primary"></i>Tambah Kegiatan Baru
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kegiatan.store') }}" method="POST">
                @csrf
                
                <div class="row g-4">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="nama_kegiatan" class="form-label fw-semibold">
                                Nama Kegiatan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" 
                                   class="form-control @error('nama_kegiatan') is-invalid @enderror" 
                                   value="{{ old('nama_kegiatan') }}" required 
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
                                      placeholder="Jelaskan detail kegiatan">{{ old('deskripsi') }}</textarea>
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
                                   value="{{ old('tanggal') }}" required>
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
                                   value="{{ old('waktu_mulai') }}" required>
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
                                   value="{{ old('waktu_selesai') }}" required>
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
                                   value="{{ old('lokasi') }}" required 
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
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <div>
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-redo me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Simpan Kegiatan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
