@extends('layouts.app')

@section('page-title', 'Detail Absensi Kegiatan')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm p-4 mb-4 rounded-4" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
        <div class="d-flex align-items-center">
            <div class="text-white p-3 rounded-4 me-4" style="background-color: rgba(255, 255, 255, 0.15);">
                <i class="fas fa-calendar-check fa-2x"></i>
            </div>
            <div>
                <h4 class="fw-bold text-white mb-1">{{ $kegiatan->nama_kegiatan }}</h4>
                <p class="text-white-50 small mb-0"><i class="fas fa-map-marker-alt me-1"></i> {{ $kegiatan->lokasi }} | <i class="fas fa-calendar-day me-1 ms-2"></i> {{ $kegiatan->tanggal }}</p>
            </div>
        </div>
    </div>

    <!-- Session Cards -->
    <div class="row g-4">
        <!-- Sesi Mulai -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 p-4 text-center">
                <h6 class="text-muted fw-bold mb-4">SESI MULAI</h6>
                
                @if($absen_mulai)
                    <div class="py-4">
                        <div class="bg-success-subtle text-success d-inline-block rounded-circle p-4 mb-3">
                            <i class="fas fa-check-circle fa-4x"></i>
                        </div>
                        <h5 class="fw-bold text-success">Berhasil Absen!</h5>
                        <p class="text-muted small mb-0">Waktu: {{ $absen_mulai->waktu_absen }}</p>
                        <p class="text-muted small">Metode: <span class="badge rounded-pill px-3 py-2" style="background-color: var(--success)20; color: var(--success);">{{ ucfirst($absen_mulai->metode) }}</span></p>
                    </div>
                @elseif($sesi_mulai && $sesi_mulai->status_sesi == 'berlangsung')
                    <div class="py-4">
                        @if($sesi_mulai->metode == 'mandiri')
                            <div class="bg-primary-subtle text-primary d-inline-block rounded-circle p-4 mb-3">
                                <i class="fas fa-hand-pointer fa-4x"></i>
                            </div>
                            <h5 class="fw-bold mb-3 text-primary">Klik untuk Absen</h5>
                            <form action="{{ route('anggota.absensi.submit', $kegiatan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipe_sesi" value="mulai">
                                <button type="submit" class="btn text-white btn-lg rounded-3 fw-bold py-2 shadow" style="background-color: var(--primary-color);">
                                    ABSEN SEKARANG
                                </button>
                            </form>
                        @else
                            <div class="bg-primary text-white d-inline-block rounded-circle p-4 mb-3">
                                <i class="fas fa-qrcode fa-4x"></i>
                            </div>
                            <h5 class="fw-bold mb-3 text-primary">Scan QR Code</h5>
                            <p class="text-muted small mb-4">Tunjukkan QR Anda ke Scanner Admin.</p>
                            <a href="{{ route('anggota.absensi.qr', $kegiatan->id) }}" class="btn text-white btn-lg rounded-3 fw-bold py-2 shadow" style="background-color: var(--primary-color);">
                                TAMPILKAN QR
                            </a>
                        @endif
                    </div>
                @else
                    <div class="py-5 opacity-50">
                        <i class="fas fa-clock fa-4x text-muted mb-3"></i>
                        <h6 class="text-muted">Sesi Belum Tersedia</h6>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sesi Selesai -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 rounded-4 p-4 text-center">
                <h6 class="text-muted fw-bold mb-4">SESI SELESAI</h6>
                
                @if($absen_selesai)
                    <div class="py-4">
                        <div class="bg-success-subtle text-success d-inline-block rounded-circle p-4 mb-3">
                            <i class="fas fa-check-double fa-4x"></i>
                        </div>
                        <h5 class="fw-bold text-success">Berhasil Absen!</h5>
                        <p class="text-muted small mb-0">Waktu: {{ $absen_selesai->waktu_absen }}</p>
                        <p class="text-muted small">Metode: <span class="badge rounded-pill px-3 py-2" style="background-color: var(--success)20; color: var(--success);">{{ ucfirst($absen_selesai->metode) }}</span></p>
                    </div>
                @elseif($sesi_selesai && $sesi_selesai->status_sesi == 'berlangsung')
                    <div class="py-4">
                        @if($sesi_selesai->metode == 'mandiri')
                            <div class="bg-info-subtle text-info d-inline-block rounded-circle p-4 mb-3">
                                <i class="fas fa-hand-pointer fa-4x"></i>
                            </div>
                            <h5 class="fw-bold mb-3 text-info">Klik untuk Absen</h5>
                            <form action="{{ route('anggota.absensi.submit', $kegiatan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipe_sesi" value="selesai">
                                <button type="submit" class="btn text-white btn-lg rounded-3 fw-bold py-2 shadow" style="background-color: var(--secondary-color);">
                                    ABSEN SEKARANG
                                </button>
                            </form>
                        @else
                            <div class="bg-info text-white d-inline-block rounded-circle p-4 mb-3">
                                <i class="fas fa-qrcode fa-4x"></i>
                            </div>
                            <h5 class="fw-bold mb-3 text-info">Scan QR Code</h5>
                            <p class="text-muted small mb-4">Tunjukkan QR Anda ke Scanner Admin.</p>
                            <a href="{{ route('anggota.absensi.qr', $kegiatan->id) }}" class="btn text-white btn-lg rounded-3 fw-bold py-2 shadow" style="background-color: var(--secondary-color);">
                                TAMPILKAN QR
                            </a>
                        @endif
                    </div>
                @else
                    <div class="py-5 opacity-50">
                        <i class="fas fa-clock fa-4x text-muted mb-3"></i>
                        <h6 class="text-muted">Sesi Belum Tersedia</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
