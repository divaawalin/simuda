@extends('layouts.app')

@section('page-title', 'QR Code Anda')

@section('content')
<div class="container-fluid px-4 text-center">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-qrcode me-2"></i> QR Code Absensi Anda</h5>
                </div>
                <div class="card-body p-5">
                    <h6 class="fw-bold mb-3 text-primary">{{ $kegiatan->nama_kegiatan }}</h6>
                    <p class="text-muted small mb-4">Tunjukkan QR Code ini kepada Admin/Sekretaris untuk di-scan.</p>
                    
                    <div class="qr-code-display mx-auto mb-4" style="width: fit-content;">
                        {!! QrCode::size(250)->generate($qrData) !!}
                    </div>
                    
                    <div class="alert alert-info border-0 shadow-sm rounded-3 py-3">
                        <i class="fas fa-info-circle me-2"></i> Pastikan QR Code ini ditampilkan saat sesi berlangsung.
                    </div>
                </div>
                <div class="card-footer bg-light p-3">
                    <a href="{{ route('anggota.absensi.detail', $kegiatan->id) }}" class="btn btn-secondary rounded-3">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Detail Kegiatan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
