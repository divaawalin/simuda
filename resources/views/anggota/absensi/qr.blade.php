@extends('layouts.app')

@section('page-title', 'QR Code Absensi Anda')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm p-4 mb-4 rounded-4" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
        <div class="d-flex align-items-center">
            <div class="text-white p-3 rounded-4 me-4" style="background-color: rgba(255, 255, 255, 0.15);">
                <i class="fas fa-qrcode fa-2x"></i>
            </div>
            <div>
                <h4 class="fw-bold text-white mb-1">QR Code Absensi</h4>
                <p class="text-white-50 small mb-0">Tunjukkan QR Code ini untuk keperluan absensi.</p>
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

