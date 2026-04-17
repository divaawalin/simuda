@extends('layouts.app')

@section('page-title', 'Dashboard Anggota')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
            <div class="card-body p-4 p-lg-5 text-white">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="fw-800 mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                        <p class="lead mb-4 opacity-90">Senang melihat Anda kembali. Pantau kegiatan terbaru dan pastikan Anda melakukan absensi tepat waktu.</p>
                        <a href="{{ route('anggota.absensi.index') }}" class="btn btn-light btn-lg px-4 fw-bold text-primary shadow-sm border-0 rounded-3">
                            <i class="fas fa-fingerprint me-2"></i> Mulai Absensi
                        </a>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block text-center">
                        <img src="https://img.freepik.com/free-vector/modern-woman-checking-her-list_23-2148348123.jpg" class="img-fluid rounded-4 shadow-lg" style="max-height: 200px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        <h5 class="fw-bold mb-4 d-flex align-items-center">
            <span class="bg-primary-subtle p-2 rounded-3 text-primary me-2">
                <i class="fas fa-layer-group"></i>
            </span>
            Konten & Informasi Terbaru
        </h5>
    </div>
    
    @forelse($kontens as $konten)
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm overflow-hidden">
            @if($konten->tipe === 'gambar')
                <div style="height: 180px; overflow: hidden;">
                    <img src="{{ route('storage.konten', $konten->file_path) }}" class="card-img-top" style="object-fit: cover; height: 100%;">
                </div>
            @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                    <i class="fas {{ $konten->tipe === 'file' ? 'fa-file-pdf text-danger' : 'fa-link text-primary' }} fa-4x opacity-20"></i>
                </div>
            @endif
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge {{ $konten->tipe === 'gambar' ? 'bg-success-subtle' : ($konten->tipe === 'file' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle') }} mb-2">
                        {{ ucfirst($konten->tipe) }}
                    </span>
                    <small class="text-muted">{{ $konten->created_at->format('d M Y') }}</small>
                </div>
                <h6 class="fw-bold mb-2">{{ $konten->nama_konten }}</h6>
                <p class="text-muted small mb-4">{{ Str::limit($konten->deskripsi, 80) }}</p>
                
                @if($konten->tipe === 'gambar')
                    <a href="{{ route('storage.konten', $konten->file_path) }}" target="_blank" class="btn btn-primary btn-sm w-100 rounded-3">
                        <i class="fas fa-eye me-1"></i> Lihat Gambar
                    </a>
                @elseif($konten->tipe === 'file')
                    <a href="{{ route('storage.konten', $konten->file_path) }}" download class="btn btn-outline-danger btn-sm w-100 rounded-3">
                        <i class="fas fa-download me-1"></i> Download File
                    </a>
                @else
                    <a href="{{ $konten->link_url }}" target="_blank" class="btn btn-outline-primary btn-sm w-100 rounded-3">
                        <i class="fas fa-external-link-alt me-1"></i> Buka Link
                    </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm p-5 text-center">
            <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-20"></i>
            <h6 class="text-muted">Belum ada konten yang dibagikan.</h6>
        </div>
    </div>
    @endforelse
</div>
@endsection
