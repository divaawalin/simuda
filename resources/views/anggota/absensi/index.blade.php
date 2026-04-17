@extends('layouts.app')

@section('page-title', 'Absensi Kegiatan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 bg-white">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white p-3 rounded-4 me-4">
                    <i class="fas fa-calendar-check fa-2x"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-1 text-primary">Daftar Kegiatan Anda</h4>
                    <p class="mb-0 text-muted">Absensi terbaru Anda akan tercatat di sini.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @forelse($kegiatans as $kegiatan)
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm transition-up overflow-hidden">
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

<style>
.transition-up:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
}
</style>
@endsection
