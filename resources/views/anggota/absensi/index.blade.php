@extends('layouts.app')

@section('page-title', 'Absensi Kegiatan')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Daftar Kegiatan Anda</h4>
                    <p>Semua kegiatan yang Anda ikuti akan tampil di sini beserta akses cepat ke detail absensi.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    @forelse($kegiatans as $kegiatan)
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge {{ $kegiatan->status == 'aktif' ? 'bg-success-subtle' : ($kegiatan->status == 'selesai' ? 'bg-secondary text-white' : 'bg-warning text-dark') }}">
                        {{ ucfirst($kegiatan->status) }}
                    </span>
                    <small class="text-muted"><i class="fas fa-calendar-alt me-1"></i> {{ $kegiatan->tanggal }}</small>
                </div>
                <h5 class="fw-bold mb-2">{{ $kegiatan->nama_kegiatan }}</h5>
                <p class="text-muted small mb-4"><i class="fas fa-map-marker-alt me-1"></i> {{ $kegiatan->lokasi ?? 'Tidak ditentukan' }}</p>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('anggota.absensi.detail', $kegiatan->id) }}" class="btn btn-primary btn-sm rounded-3 shadow-sm">
                        <i class="fas fa-info-circle me-1"></i> Lihat Detail Absensi
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm p-5 text-center">
            <i class="fas fa-calendar-times fa-4x text-muted mb-3 opacity-20"></i>
            <h5 class="text-muted">Belum ada kegiatan yang Anda ikuti.</h5>
            <p class="text-muted small">Tetap pantau informasi terbaru dari admin!</p>
        </div>
    </div>
    @endforelse
    </div>
</div>
@endsection
