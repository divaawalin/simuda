@extends('layouts.app')

@section('title', 'QR Code Absensi - ' . $kegiatan->nama_kegiatan)

@section('content')
<div class="container">
    <h1 class="mt-4 mb-3">QR Code Absensi untuk Kegiatan: "{{ $kegiatan->nama_kegiatan }}"</h1>

    <div class="card mb-4 text-center">
        <div class="card-header">
            <i class="fas fa-qrcode me-1"></i>
            Kode QR Sesi Aktif
        </div>
        <div class="card-body">
            @if($activeSession && $activeSession->qr_token)
                <p>Arahkan aplikasi absensi Anda ke kode QR ini untuk melakukan presensi.</p>
                <div class="qr-code-container" style="display: inline-block; margin-top: 20px; margin-bottom: 20px;">
                    {!! $qrCodeSvg !!}
                </div>
                <p class="text-muted">Token: {{ $activeSession->qr_token }}</p>
                <p class="text-muted">Sesi dimulai pada: {{ $activeSession->started_at->format('Y-m-d H:i:s') }}</p>
                <small class="text-danger">Kode QR ini akan valid hingga sesi berakhir.</small>
            @else
                <p class="text-warning">Tidak ada sesi QR Code aktif untuk kegiatan ini.</p>
                <a href="{{ route('admin.absensi.sesi', $kegiatan->id) }}" class="btn btn-secondary mt-3">Kembali ke Kelola Sesi</a>
            @endif
        </div>
        <div class="card-footer">
             <a href="{{ route('admin.absensi.sesi', $kegiatan->id) }}" class="btn btn-primary">Kembali ke Kelola Sesi</a>
        </div>
    </div>

    {{-- Optional: If you want to show a scanner interface on the admin's device too --}}
    {{-- This would typically require client-side JS for camera access --}}
    {{-- For now, we focus on displaying the code to be scanned by members --}}

</div>
@endsection

@push('scripts')
<script>
    // You could potentially add JavaScript here to auto-refresh the QR code or
    // to provide a visual indicator if the session ends.
    // For this basic implementation, we'll just display the static QR code.
</script>
@endpush
