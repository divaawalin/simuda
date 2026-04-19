@extends('layouts.app')

@section('page-title', 'Dashboard Anggota')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Portal Anggota</h4>
                    <p>Halo, {{ auth()->user()->name }}. Akses kegiatan, absensi, dan materi admin dari satu dashboard yang lebih fokus.</p>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <span class="badge rounded-pill px-3 py-2 text-white border border-light-subtle">{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        @foreach ([
            ['title' => 'Kegiatan Tersedia', 'value' => $kegiatans->count(), 'icon' => 'fa-calendar-check', 'color' => 'primary'],
            ['title' => 'Hadir Hari Ini', 'value' => $kehadiranHariIni ?? 0, 'icon' => 'fa-user-check', 'color' => 'success'],
            ['title' => 'Total Konten', 'value' => $konten->count(), 'icon' => 'fa-layer-group', 'color' => 'info']
        ] as $stat)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 rounded-3 me-3" style="background-color: var(--{{ $stat['color'] }})20; color: var(--{{ $stat['color'] }});">
                        <i class="fas {{ $stat['icon'] }} fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">{{ $stat['value'] }}</h5>
                        <p class="text-muted small mb-0">{{ $stat['title'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-calendar-week me-2" style="color: var(--primary-color);"></i>Kegiatan Anda</h5>
        <a href="{{ route('anggota.absensi.index') }}" class="btn btn-outline-primary px-4">Lihat Semua</a>
    </div>
    <div class="row g-4">
        @forelse($kegiatans as $kegiatan)
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        @php
                            $sColor = $kegiatan->status == 'aktif' ? 'var(--primary-color)' : '#6c757d';
                        @endphp
                        <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $sColor }}20; color: {{ $sColor }};">
                            {{ ucfirst($kegiatan->status) }}
                        </span>
                        <small class="text-muted">{{ $kegiatan->tanggal->format('d M Y') }}</small>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">{{ $kegiatan->nama_kegiatan }}</h6>
                    <p class="text-muted small mb-4"><i class="fas fa-map-marker-alt me-1" style="color: var(--secondary-color);"></i> {{ $kegiatan->lokasi }}</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('anggota.absensi.detail', $kegiatan->id) }}" class="btn text-white rounded-3 fw-bold" style="background-color: var(--primary-color);">Scan Absensi</a>
                        <a href="{{ route('anggota.absensi.detail', $kegiatan->id) }}" class="btn btn-outline-primary rounded-3 fw-bold">Detail</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">Belum ada kegiatan untuk diikuti.</div>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $kegiatans->links('pagination::bootstrap-5', ['kegiatanPage' => true]) }}
    </div>

    <!-- Konten -->
    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
        <h5 class="fw-bold mb-0 text-dark">
            <i class="fas fa-folder-open me-2" style="color: var(--secondary-color);"></i>Konten Dari Admin
        </h5>
        <a href="{{ route('anggota.konten.index') }}" class="btn btn-outline-primary px-4">Buka Library</a>
    </div>
    <div class="row g-4">
        @forelse($konten as $item)
        @php
            $typeColor = $item->tipe === 'gambar' ? 'var(--primary-color)' : ($item->tipe === 'file' ? '#dc3545' : 'var(--secondary-color)');
            $downloadUrl = $item->file_path ? route('storage.konten', $item->file_path) : null;
        @endphp
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                @if($item->tipe === 'gambar' && $downloadUrl)
                <div style="height: 220px; background: #f4f7fb;">
                    <img src="{{ $downloadUrl }}" alt="{{ $item->nama_konten }}" class="w-100 h-100" style="object-fit: cover;">
                </div>
                @endif
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $typeColor }}20; color: {{ $typeColor }};">
                            {{ ucfirst($item->tipe) }}
                        </span>
                        <small class="text-muted text-end">{{ $item->created_at?->format('d M Y') }}</small>
                    </div>

                    <h6 class="fw-bold text-dark mb-2">{{ $item->nama_konten }}</h6>
                    <p class="text-muted small mb-3">{{ $item->deskripsi ?: 'Tidak ada deskripsi untuk konten ini.' }}</p>

                    @if($item->tipe !== 'link' && $item->file_path)
                    <p class="text-muted small mb-4">
                        <i class="fas {{ $item->tipe === 'gambar' ? 'fa-image' : 'fa-file-alt' }} me-1" style="color: {{ $typeColor }};"></i>
                        {{ \Illuminate\Support\Str::limit($item->file_path, 40) }}
                    </p>
                    @elseif($item->tipe === 'link' && $item->link_url)
                    <p class="text-muted small mb-4">
                        <i class="fas fa-link me-1" style="color: {{ $typeColor }};"></i>
                        {{ \Illuminate\Support\Str::limit($item->link_url, 45) }}
                    </p>
                    @endif

                    <div class="mt-auto d-grid">
                        @if($item->tipe === 'link' && $item->link_url)
                        <a href="{{ $item->link_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-3 fw-bold">
                            <i class="fas fa-external-link-alt me-2"></i>Lihat
                        </a>
                        @elseif($downloadUrl)
                        <a href="{{ $downloadUrl }}" download class="btn text-white rounded-3 fw-bold" style="background-color: var(--primary-color);">
                            <i class="fas fa-download me-2"></i>Download
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-5 text-muted">
                    Belum ada konten yang ditambahkan admin.
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $konten->links('pagination::bootstrap-5', ['kontenPage' => true]) }}
    </div>
</div>
@endsection
