@extends('layouts.app')

@section('page-title', 'QR Code Absensi Anda')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon"><i class="fas fa-qrcode"></i></div>
                <div>
                    <h4 class="fw-bold">QR Code Absensi</h4>
                    <p>Tunjukkan QR Code ini saat proses absensi berlangsung.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Display Card -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-5 text-center">
                    <h5 class="fw-bold text-primary mb-2">{{ $kegiatan->nama_kegiatan }}</h5>
                    <p class="text-muted small mb-4"><i class="fas fa-calendar-alt me-1"></i> {{ $kegiatan->tanggal }}</p>

                    <div class="qr-code-container mb-4 mx-auto d-inline-block p-4 rounded-4 shadow-sm" style="background-color: var(--primary-color)10;">
                        {!! QrCode::size(250)->generate($qrData) !!}
                    </div>

                    <div class="alert alert-primary border-0 shadow-sm rounded-3 py-3" role="alert" style="background-color: var(--primary-color)10; color: var(--primary-color);">
                        <i class="fas fa-info-circle me-2"></i> Pastikan QR Code ini ditampilkan saat sesi absensi berlangsung.
                    </div>
                </div>
                <div class="card-footer bg-light p-3">
                    <a href="{{ route('anggota.absensi.detail', $kegiatan->id) }}" class="btn btn-secondary rounded-3 w-100">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Detail Kegiatan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
