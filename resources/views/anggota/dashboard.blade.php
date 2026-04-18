@extends('layouts.app')

@section('page-title', 'Dashboard Anggota')

@section('content')
<div class="main-container">
    <!-- Welcome Banner with Decorative Pattern -->
    <div class="card border-0 shadow-sm mb-5 overflow-hidden position-relative" 
         style="background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);">
        <!-- Decorative elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
            <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute;">
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <circle cx="5" cy="5" r="1" fill="white"/>
                </pattern>
                <rect width="100" height="100" fill="url(#grid)"/>
            </svg>
        </div>
        <div class="position-absolute top-0 end-0 w-50 h-100 bg-white opacity-10" style="transform: skewX(-20deg) translateX(25%);"></div>
        <div class="position-absolute bottom-0 start-0 w-25 h-25 bg-white opacity-15 rounded-circle" style="transform: translate(-50%, 50%);"></div>
        
        <div class="card-body position-relative p-4 p-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-3 backdrop-blur">
                            <i class="fas fa-fingerprint fa-2x text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-white fw-800 mb-1 display-6">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                            <p class="text-white-50 mb-0 fs-5">Pantau kegiatan Anda dan lakukan absensi dengan mudah.</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 me-2">
                            <i class="fas fa-user-tie me-1"></i> {{ ucfirst(auth()->user()->role) }}
                        </span>
                        <span class="badge bg-white bg-opacity-25 text-white px-3 py-2">
                            <i class="fas fa-clock me-1"></i> {{ now()->format('d M Y') }}
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <i class="fas fa-qrcode fa-8x text-white opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="bg-primary-subtle rounded-3 d-inline-flex p-3 mb-3">
                        <i class="fas fa-calendar-check fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-primary">{{ $kegiatans->count() }}</h5>
                    <p class="text-muted mb-0">Kegiatan Tersedia</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="bg-success-subtle rounded-3 d-inline-flex p-3 mb-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold text-success">{{ $kehadiranHariIni ?? 0 }}</h5>
                    <p class="text-muted mb-0">Hadir Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="bg-info-subtle rounded-3 d-inline-flex p-3 mb-3">
                        <i class="fas fa-layer-group fa-2x text-info"></i>
                    </div>
                    <h5 class="fw-bold text-info">{{ App\Models\Konten::count() }}</h5>
                    <p class="text-muted mb-0">Total Konten</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kegiatan Section -->
    <div class="row g-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    <span class="bg-primary-subtle p-2 rounded-3 me-2">
                        <i class="fas fa-calendar-week text-primary"></i>
                    </span>
                    Kegiatan Anda
                </h5>
                <a href="{{ route('anggota.absensi.index') }}" class="btn btn-outline-primary btn-sm rounded-3">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        
        @forelse($kegiatans as $kegiatan)
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm overflow-hidden transition-up hover-lift">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge 
                            @if($kegiatan->status == 'aktif') bg-success-subtle text-success px-3 py-2
                            @elseif($kegiatan->status == 'selesai') bg-secondary-subtle text-secondary px-3 py-2
                            @else bg-warning-subtle text-warning px-3 py-2 @endif rounded-pill">
                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i> 
                            {{ ucfirst($kegiatan->status) }}
                        </span>
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i> 
                            {{ $kegiatan->tanggal->format('d M Y') }}
                        </small>
                    </div>
                    
                    <h5 class="fw-bold mb-2">{{ $kegiatan->nama_kegiatan }}</h5>
                    <p class="text-muted small mb-4">
                        <i class="fas fa-map-marker-alt me-1 text-danger"></i> 
                        {{ $kegiatan->lokasi ?? 'Lokasi belum ditentukan' }}
                    </p>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('anggota.absensi.detail', $kegiatan->id) }}" class="btn btn-primary btn-sm rounded-3 shadow-sm">
                            <i class="fas fa-qrcode me-1"></i> Scan Absensi
                        </a>
                        <a href="{{ route('anggota.absensi.detail', $kegiatan->id) }}" class="btn btn-outline-primary btn-sm rounded-3">
                            <i class="fas fa-info-circle me-1"></i> Lihat Detail
                        </a>
                    </div>
                </div>
                
                <!-- Decorative bottom border -->
                <div class="card-footer bg-transparent border-0 pb-3">
                    <div class="progress" style="height: 4px; background: rgba(0,0,0,0.05); border-radius: 2px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 65%; border-radius: 2px;"></div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm p-5 text-center">
                <div class="mb-4">
                    <i class="fas fa-calendar-times fa-4x text-muted opacity-25"></i>
                </div>
                <h5 class="text-muted mb-2">Belum ada kegiatan yang Anda ikuti.</h5>
                <p class="text-muted small mb-0">Tetap pantau informasi terbaru dari admin!</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Konten & Informasi Terbaru -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">
                    <span class="bg-info-subtle p-2 rounded-3 me-2">
                        <i class="fas fa-layer-group text-info"></i>
                    </span>
                    Konten & Informasi Terbaru
                </h5>
                <a href="#" class="btn btn-outline-info btn-sm rounded-3">
                    Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        
        @forelse($kontens as $konten)
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm overflow-hidden hover-lift">
                @if($konten->tipe === 'gambar')
                    <div style="height: 180px; overflow: hidden; position: relative;">
                        <img src="{{ route('storage.konten', $konten->file_path) }}" class="card-img-top" 
                             style="object-fit: cover; height: 100%; transition: transform 0.3s;" 
                             onmouseover="this.style.transform='scale(1.05)'" 
                             onmouseout="this.style.transform='scale(1)'">
                    </div>
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                        <i class="fas {{ $konten->tipe === 'file' ? 'fa-file-pdf text-danger' : 'fa-link text-primary' }} fa-4x opacity-25"></i>
                    </div>
                @endif
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge 
                            @if($konten->tipe === 'gambar') bg-success-subtle text-success
                            @elseif($konten->tipe === 'file') bg-danger-subtle text-danger
                            @else bg-primary-subtle text-primary @endif 
                            px-3 py-2 rounded-pill">
                            <i class="fas 
                                @if($konten->tipe === 'gambar') fa-image
                                @elseif($konten->tipe === 'file') fa-file-alt
                                @else fa-link @endif me-1 small"></i>
                            {{ ucfirst($konten->tipe) }}
                        </span>
                        <small class="text-muted">{{ $konten->created_at->format('d M Y') }}</small>
                    </div>
                    
                    <h6 class="fw-bold mb-2">{{ $konten->nama_konten }}</h6>
                    <p class="text-muted small mb-4">{{ Str::limit($konten->deskripsi, 80) }}</p>
                    
                    @if($konten->tipe === 'gambar')
                        <a href="{{ route('storage.konten', $konten->file_path) }}" target="_blank" class="btn btn-primary btn-sm w-100 rounded-3 shadow-sm">
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
</div>
@endsection
