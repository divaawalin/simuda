@extends('layouts.app')

@section('page-title', 'Manajemen Absensi')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 text-center bg-primary text-white">
            <h4 class="fw-800 mb-2">Pilih Kegiatan untuk Absensi</h4>
            <p class="mb-0 opacity-75">Silakan pilih kegiatan di bawah ini untuk mengelola daftar hadir, sesi, dan rekap absensi.</p>
        </div>
    </div>
</div>

<div class="row">
    @forelse($kegiatans as $kegiatan)
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 transition-up overflow-hidden">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge {{ $kegiatan->status == 'aktif' ? 'bg-success-subtle' : ($kegiatan->status == 'selesai' ? 'bg-secondary text-white' : 'bg-warning text-dark') }}">
                        {{ ucfirst($kegiatan->status) }}
                    </span>
                    <small class="text-muted"><i class="fas fa-calendar-alt me-1"></i> {{ $kegiatan->tanggal }}</small>
                </div>
                <h5 class="fw-bold mb-2">{{ $kegiatan->nama_kegiatan }}</h5>
                <p class="text-muted small mb-4"><i class="fas fa-map-marker-alt me-1"></i> {{ $kegiatan->lokasi }}</p>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('absensi.invite', $kegiatan->id) }}" class="btn btn-outline-primary btn-sm rounded-3">
                        <i class="fas fa-user-plus me-1"></i> Invite Anggota
                    </a>
                    <a href="{{ route('absensi.sesi', $kegiatan->id) }}" class="btn btn-success btn-sm rounded-3">
                        <i class="fas fa-clock me-1"></i> Kelola Sesi & Absen
                    </a>
                    <a href="{{ route('absensi.rekap', $kegiatan->id) }}" class="btn btn-info btn-sm text-white rounded-3">
                        <i class="fas fa-list-alt me-1"></i> Rekap Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="card border-0 shadow-sm p-5">
            <i class="fas fa-calendar-times fa-4x text-muted mb-3 opacity-20"></i>
            <h5 class="text-muted">Tidak ada kegiatan aktif saat ini.</h5>
            <p class="text-muted small">Buat kegiatan baru di menu Manajemen Kegiatan.</p>
        </div>
    </div>
    @endforelse
</div>

<style>
.transition-up:hover {
    transform: translateY(-8px);
    border: 1px solid var(--secondary-color) !important;
}
</style>
@endsection
