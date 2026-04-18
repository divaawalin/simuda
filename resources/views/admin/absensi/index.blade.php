@extends('layouts.app')

@section('page-title', 'Manajemen Absensi')

@section('content')
<div class="container-fluid px-0">
    @php
        $aktifCount = $kegiatans->where('status', 'aktif')->count();
    @endphp

    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Attendance Operations</h4>
                    <p>Pilih kegiatan, buka sesi, undang anggota, dan baca rekap kehadiran dari panel operasional ini.</p>
                </div>
            </div>
            <span class="badge rounded-pill px-3 py-2 text-white border border-light-subtle">{{ $aktifCount }} Kegiatan Aktif</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="row g-4">
                @forelse($kegiatans as $kegiatan)
                <div class="col-xl-6">
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
        <div class="col-xl-4">
            <div class="card border-0 rounded-4 h-100">
                <div class="card-header border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-route me-2" style="color:var(--secondary-color);"></i>Alur Absensi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <div class="soft-card p-3">
                            <strong class="d-block mb-1">1. Invite anggota</strong>
                            <small class="text-muted">Tentukan siapa yang berhak mengikuti sesi absensi.</small>
                        </div>
                        <div class="soft-card p-3">
                            <strong class="d-block mb-1">2. Buka sesi</strong>
                            <small class="text-muted">Aktifkan mode mandiri atau scanner QR dari admin.</small>
                        </div>
                        <div class="soft-card p-3">
                            <strong class="d-block mb-1">3. Lihat rekap</strong>
                            <small class="text-muted">Evaluasi kehadiran mulai dan selesai untuk setiap anggota.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
