@extends('layouts.app')

@section('page-title', 'Manajemen Absensi')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="mb-4">
        <h4 class="fw-bold mb-1 text-dark">Manajemen Absensi</h4>
        <p class="text-muted small mb-0">Pilih kegiatan untuk mengelola daftar hadir, sesi, dan rekap data.</p>
    </div>

    <!-- Activity Cards -->
    <div class="row g-4">
        @forelse($kegiatans as $kegiatan)
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        @php
                            $statusColor = $kegiatan->status == 'aktif' ? 'var(--primary-color)' : ($kegiatan->status == 'selesai' ? '#6c757d' : '#ffc107');
                        @endphp
                        <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $statusColor }}20; color: {{ $statusColor }};">
                            {{ ucfirst($kegiatan->status) }}
                        </span>
                        <small class="text-muted small"><i class="fas fa-calendar-alt me-1"></i> {{ $kegiatan->tanggal }}</small>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ $kegiatan->nama_kegiatan }}</h5>
                    <p class="text-muted small mb-4"><i class="fas fa-map-marker-alt me-1" style="color: var(--secondary-color);"></i> {{ $kegiatan->lokasi }}</p>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('absensi.invite', $kegiatan->id) }}" class="btn btn-outline-primary rounded-3 fw-bold py-2">
                            <i class="fas fa-user-plus me-1"></i> Invite Anggota
                        </a>
                        <a href="{{ route('absensi.sesi', $kegiatan->id) }}" class="btn text-white rounded-3 fw-bold py-2" style="background-color: var(--primary-color);">
                            <i class="fas fa-clock me-1"></i> Kelola Sesi & Absen
                        </a>
                        <a href="{{ route('absensi.rekap', $kegiatan->id) }}" class="btn btn-outline-info rounded-3 fw-bold py-2" style="color: var(--secondary-color); border-color: var(--secondary-color);">
                            <i class="fas fa-list-alt me-1"></i> Rekap Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-calendar-times fa-4x mb-3 opacity-20"></i>
            <h5>Tidak ada kegiatan ditemukan.</h5>
        </div>
        @endforelse
    </div>
</div>
@endsection
