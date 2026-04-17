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
                    <h4 class="fw-800 mb-1 text-primary">{{ $kegiatan->nama_kegiatan }}</h4>
                    <p class="mb-0 text-muted"><i class="fas fa-map-marker-alt me-1"></i> {{ $kegiatan->lokasi }} | <i class="fas fa-calendar-day me-1 ms-2"></i> {{ $kegiatan->tanggal }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Sesi Mulai -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 overflow-hidden text-center p-4">
            <h6 class="text-muted fw-bold mb-4">SESI MULAI</h6>
            
            @if($absen_mulai)
                <div class="py-4">
                    <div class="bg-success-subtle text-success d-inline-block rounded-circle p-4 mb-3">
                        <i class="fas fa-check-circle fa-4x"></i>
                    </div>
                    <h5 class="fw-bold text-success">Berhasil Absen!</h5>
                    <p class="text-muted small mb-0">Waktu: {{ $absen_mulai->waktu_absen }}</p>
                    <p class="text-muted small">Metode: <span class="badge bg-success-subtle">{{ ucfirst($absen_mulai->metode) }}</span></p>
                </div>
            @elseif($sesi_mulai && $sesi_mulai->status_sesi == 'berlangsung')
                <div class="py-4">
                    @if($sesi_mulai->metode == 'mandiri')
                        <div class="bg-primary-subtle text-primary d-inline-block rounded-circle p-4 mb-3">
                            <i class="fas fa-hand-pointer fa-4x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Klik untuk Absen</h5>
                        <form action="{{ route('anggota.absensi.submit', $kegiatan->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="tipe_sesi" value="mulai">
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-3 fw-bold shadow">
                                ABSEN SEKARANG
                            </button>
                        </form>
                    @else
                        <div class="bg-primary text-white d-inline-block rounded-circle p-4 mb-3">
                            <i class="fas fa-qrcode fa-4x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Scan QR Code Anda</h5>
                        <p class="text-muted small mb-4">Tunjukkan QR Code Anda ke Scanner Admin/Sekretaris.</p>
                        <a href="{{ route('anggota.absensi.qr', $kegiatan->id) }}" class="btn btn-primary btn-lg px-5 rounded-3 fw-bold shadow">
                            TAMPILKAN QR
                        </a>
                    @endif
                </div>
            @else
                <div class="py-5 opacity-50">
                    <i class="fas fa-clock fa-4x text-muted mb-3"></i>
                    <h6 class="text-muted">Sesi belum tersedia atau sudah ditutup.</h6>
                </div>
            @endif
        </div>
    </div>

    <!-- Sesi Selesai -->
    <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 overflow-hidden text-center p-4">
            <h6 class="text-muted fw-bold mb-4">SESI SELESAI</h6>
            
            @if($absen_selesai)
                <div class="py-4">
                    <div class="bg-success-subtle text-success d-inline-block rounded-circle p-4 mb-3">
                        <i class="fas fa-check-double fa-4x"></i>
                    </div>
                    <h5 class="fw-bold text-success">Berhasil Absen!</h5>
                    <p class="text-muted small mb-0">Waktu: {{ $absen_selesai->waktu_absen }}</p>
                    <p class="text-muted small">Metode: <span class="badge bg-success-subtle">{{ ucfirst($absen_selesai->metode) }}</span></p>
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
                            <button type="submit" class="btn btn-info btn-lg px-5 rounded-3 fw-bold shadow text-white">
                                ABSEN SEKARANG
                            </button>
                        </form>
                    @else
                        <div class="bg-info text-white d-inline-block rounded-circle p-4 mb-3">
                            <i class="fas fa-qrcode fa-4x"></i>
                        </div>
                        <h5 class="fw-bold mb-3 text-info">Scan QR Code Anda</h5>
                        <p class="text-muted small mb-4">Tunjukkan QR Code Anda ke Scanner Admin/Sekretaris.</p>
                        <a href="{{ route('anggota.absensi.qr', $kegiatan->id) }}" class="btn btn-info btn-lg px-5 rounded-3 fw-bold shadow text-white">
                            TAMPILKAN QR
                        </a>
                    @endif
                </div>
            @else
                <div class="py-5 opacity-50">
                    <i class="fas fa-clock fa-4x text-muted mb-3"></i>
                    <h6 class="text-muted">Sesi belum tersedia atau sudah ditutup.</h6>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
