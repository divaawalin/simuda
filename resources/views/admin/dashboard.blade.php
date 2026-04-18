@extends('layouts.app')

@section('page-title', 'Dashboard Admin')

@section('content')
@php
    use App\Models\User;
    use App\Models\Konten;
    use App\Models\Absensi;
    $adminCount = User::whereIn('role', ['admin', 'sekretaris', 'ketua'])->count();
    $kehadiranHariIni = Absensi::whereDate('waktu_absen', today())->count();
    $kontenCount = Konten::count();
@endphp

<div class="container-fluid px-4">
    <!-- Welcome Banner with Glassmorphism -->
    <div class="card border-0 shadow-sm mb-4 position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); border-radius: 20px;">
        <div class="position-absolute top-0 end-0 p-4 opacity-10">
            <i class="fas fa-chart-line fa-10x text-white"></i>
        </div>
        <div class="card-body p-4 p-md-5 text-white">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="fw-bold mb-2">Halo, {{ auth()->user()->name }}!</h1>
                    <p class="mb-4 opacity-75">Selamat datang kembali di sistem manajemen {{ config('app.name') }}.</p>
                    <div class="d-flex gap-3">
                        <div class="bg-white bg-opacity-10 px-3 py-2 rounded-pill backdrop-blur">
                            <i class="fas fa-calendar-day me-2"></i> {{ now()->format('d F Y') }}
                        </div>
                        <div class="bg-white bg-opacity-10 px-3 py-2 rounded-pill backdrop-blur">
                            <i class="fas fa-clock me-2"></i> <span id="clock">--:--</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        @foreach ([
            ['title' => 'Total Anggota', 'value' => $totalAnggota ?? 0, 'icon' => 'fa-users', 'color' => 'var(--primary-color)'],
            ['title' => 'Total Kegiatan', 'value' => $totalKegiatan ?? 0, 'icon' => 'fa-calendar-check', 'color' => 'var(--secondary-color)'],
            ['title' => 'Hadir Hari Ini', 'value' => $absensiHariIni ?? 0, 'icon' => 'fa-user-check', 'color' => 'var(--primary-color)'],
            ['title' => 'Total Konten', 'value' => $kontenCount, 'icon' => 'fa-layer-group', 'color' => 'var(--secondary-color)']
        ] as $stat)
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted text-uppercase small fw-bold mb-1">{{ $stat['title'] }}</p>
                            <h3 class="fw-bold text-dark mb-0">{{ $stat['value'] }}</h3>
                        </div>
                        <div class="p-3 rounded-3" style="background-color: {{ $stat['color'] }}20; color: {{ $stat['color'] }};">
                            <i class="fas {{ $stat['icon'] }} fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-history me-2" style="color: var(--primary-color);"></i>Aktivitas Terbaru</h5>
                </div>
                <div class="card-body px-4">
                    <div class="list-group list-group-flush">
                        @for ($i = 0; $i < 3; $i++)
                        <div class="list-group-item px-0 border-0 d-flex gap-3 align-items-center py-3">
                            <div class="p-3 rounded-3" style="background-color: var(--primary-color)10;"><i class="fas fa-file-alt" style="color: var(--primary-color);"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold">Update Sistem</h6>
                                <p class="text-muted small mb-0">Sistem telah diperbarui ke versi terbaru.</p>
                            </div>
                            <small class="text-muted ms-auto">2 jam lalu</small>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-bolt me-2" style="color: var(--secondary-color);"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body px-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('anggota.create') }}" class="btn text-white btn-lg rounded-3 fw-bold" style="background-color: var(--primary-color);">Tambah Anggota</a>
                        <a href="{{ route('kegiatan.create') }}" class="btn btn-lg rounded-3 fw-bold" style="border: 2px solid var(--primary-color); color: var(--primary-color);">Buat Kegiatan</a>
                        <a href="{{ route('konten.create') }}" class="btn btn-lg rounded-3 fw-bold" style="border: 2px solid var(--secondary-color); color: var(--secondary-color);">Upload Konten</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setInterval(() => {
        document.getElementById('clock').innerText = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
    }, 1000);
</script>
@endsection

