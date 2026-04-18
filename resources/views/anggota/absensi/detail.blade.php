@extends('layouts.app')

@section('page-title', 'Detail Absensi Kegiatan')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">{{ $kegiatan->nama_kegiatan }}</h4>
                    <p><i class="fas fa-map-marker-alt me-1"></i>{{ $kegiatan->lokasi }} <span class="mx-2">•</span> <i class="fas fa-calendar-day me-1"></i>{{ $kegiatan->tanggal }}</p>
                </div>
            </div>
            <a href="{{ route('anggota.absensi.index') }}" class="btn btn-light px-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <small class="text-uppercase fw-bold text-muted d-block mb-2">Status Kegiatan</small>
                    <span class="badge rounded-pill px-3 py-2" style="background:rgba(4,142,142,.12);color:var(--primary-color);">{{ ucfirst($kegiatan->status) }}</span>
                    <hr>
                    <small class="text-uppercase fw-bold text-muted d-block mb-2">Panduan</small>
                    <p class="text-muted small mb-0">Gunakan panel sesi mulai dan sesi selesai di bawah untuk melihat apakah Anda perlu scan QR atau melakukan absensi mandiri.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6"><div class="soft-card p-3 h-100"><small class="text-uppercase fw-bold text-muted d-block mb-2">Sesi Mulai</small><strong>{{ $absen_mulai ? 'Sudah Tercatat' : (($sesi_mulai && $sesi_mulai->status_sesi == 'berlangsung') ? 'Sedang Tersedia' : 'Belum Tersedia') }}</strong></div></div>
                        <div class="col-md-6"><div class="soft-card p-3 h-100"><small class="text-uppercase fw-bold text-muted d-block mb-2">Sesi Selesai</small><strong>{{ $absen_selesai ? 'Sudah Tercatat' : (($sesi_selesai && $sesi_selesai->status_sesi == 'berlangsung') ? 'Sedang Tersedia' : 'Belum Tersedia') }}</strong></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
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
