@extends('layouts.app')

@section('page-title', 'Dashboard Anggota')

@section('content')
<div class="container-fluid px-0">
    <!-- Welcome Banner with Glassmorphism -->
    <div class="card border-0 shadow-sm mb-4 position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%); border-radius: 20px;">
        <div class="position-absolute top-0 end-0 p-4 opacity-10">
            <i class="fas fa-fingerprint fa-10x text-white"></i>
        </div>
        <div class="card-body p-4 p-md-5 text-white">
            <h1 class="fw-bold mb-2">Halo, {{ auth()->user()->name }}!</h1>
            <p class="mb-4 opacity-75">Selamat datang di portal anggota {{ config('app.name') }}. Pantau kegiatan dan lakukan absensi di sini.</p>
            <div class="d-flex gap-3">
                <div class="bg-white bg-opacity-10 px-3 py-2 rounded-pill backdrop-blur"><i class="fas fa-calendar-day me-2"></i> {{ now()->format('d F Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        @foreach ([
            ['title' => 'Kegiatan Tersedia', 'value' => $kegiatans->count(), 'icon' => 'fa-calendar-check', 'color' => 'primary'],
            ['title' => 'Hadir Hari Ini', 'value' => $kehadiranHariIni ?? 0, 'icon' => 'fa-user-check', 'color' => 'success'],
            ['title' => 'Total Konten', 'value' => App\Models\Konten::count(), 'icon' => 'fa-layer-group', 'color' => 'info']
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

    <!-- Kegiatan -->
    <h5 class="fw-bold mb-4 text-dark"><i class="fas fa-calendar-week me-2" style="color: var(--primary-color);"></i>Kegiatan Anda</h5>
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
</div>
@endsection
