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

<div class="main-container">
    <!-- Welcome Banner with Decorative Pattern -->
    <div class="card border-0 shadow-sm mb-5 overflow-hidden position-relative" 
         style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
        <!-- Decorative elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 pattern-bg"></div>
        <div class="position-absolute top-0 end-0 w-50 h-100 bg-white opacity-5" style="transform: skewX(-20deg) translateX(25%);"></div>
        <div class="position-absolute bottom-0 start-0 w-25 h-25 bg-white opacity-10 rounded-circle" style="transform: translate(-50%, 50%);"></div>
        
        <div class="card-body position-relative p-4 p-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-3 backdrop-blur pulse-glow">
                            <i class="fas fa-shield-alt fa-2x text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-white fw-800 mb-1 display-6">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                            @php
                                $hour = date('H');
                                $greeting = $hour < 12 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
                            @endphp
                            <p class="text-white-50 mb-0 fs-5">{{ $greeting }}! Pantau dan kelola organisasi Anda dari sini.</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 me-2">
                            <i class="fas fa-user-tie me-1"></i> {{ ucfirst(auth()->user()->role) }}
                        </span>
                        <span class="badge bg-white bg-opacity-25 text-white px-3 py-2">
                            <i class="fas fa-clock me-1"></i> {{ now()->format('H:i') }}
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <i class="fas fa-chart-pie fa-8x text-white opacity-20 float-animation"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Overview Row -->
    <div class="row g-4 mb-2">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary-subtle p-3 rounded-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-users text-primary fa-lg"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h3 class="fw-bold mb-0 stats-number">{{ $totalAnggota }}</h3>
                            <p class="text-muted small mb-0">Total Anggota</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info-subtle p-3 rounded-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calendar-check text-info fa-lg"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h3 class="fw-bold mb-0" style="color: #5FC6D7;">{{ $totalKegiatan }}</h3>
                            <p class="text-muted small mb-0">Total Kegiatan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success-subtle p-3 rounded-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user-check text-success fa-lg"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h3 class="fw-bold mb-0 text-success">{{ $absensiHariIni }}</h3>
                            <p class="text-muted small mb-0">Hadir Hari Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning-subtle p-3 rounded-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-layer-group text-warning fa-lg"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h3 class="fw-bold mb-0" style="color: #f39c12;">{{ $kontenCount }}</h3>
                            <p class="text-muted small mb-0">Total Konten</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4">
        <!-- Left Column - Activity & Stats -->
        <div class="col-lg-8">
            <!-- Activity Overview Card -->
            <div class="card border-0 shadow-sm mb-4 card-header-gradient">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0 fw-bold text-primary mb-1">
                                <i class="fas fa-chart-line me-2"></i>Ringkasan Aktivitas
                            </h6>
                            <p class="text-muted small mb-0">Detail statistik dan performa sistem</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm dropdown-toggle rounded-3 shadow-sm" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-chart-bar me-1"></i> Lihat Grafik
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                                <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                                <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="card-body px-4">
                    <!-- Stats Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="text-center p-4 rounded-3 bg-primary-subtle hover-lift">
                                <div class="mb-2">
                                    <i class="fas fa-user-plus fa-2x text-primary pulse-indicator"></i>
                                </div>
                                <h4 class="fw-bold text-primary mb-1">12</h4>
                                <p class="text-muted small mb-0">Anggota Baru</p>
                                <small class="text-success"><i class="fas fa-arrow-up me-1"></i> +12%</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-4 rounded-3 bg-success-subtle hover-lift">
                                <div class="mb-2">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                                <h4 class="fw-bold text-success mb-1">94%</h4>
                                <p class="text-muted small mb-0">Tingkat Kehadiran</p>
                                <small class="text-success"><i class="fas fa-arrow-up me-1"></i> +5%</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-4 rounded-3 bg-info-subtle hover-lift">
                                <div class="mb-2">
                                    <i class="fas fa-calendar-plus fa-2x text-info"></i>
                                </div>
                                <h4 class="fw-bold text-info mb-1">5</h4>
                                <p class="text-muted small mb-0">Kegiatan Aktif</p>
                                <small class="text-muted">Bulan ini</small>
                            </div>
                        </div>
                    </div>

                    <!-- Divider with icon -->
                    <div class="divider-with-icon">
                        <i class="fas fa-stream me-2"></i> Aktivitas Terbaru
                    </div>

                    <!-- Activity Feed -->
                    <div class="activity-feed">
                        <div class="activity-item d-flex align-items-start mb-3 p-3 rounded-3">
                            <div class="bg-primary-subtle rounded-circle p-2 me-3 flex-shrink-0">
                                <i class="fas fa-user-plus text-primary small"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <p class="mb-0 fw-semibold small">Anggota baru bergabung</p>
                                    <small class="text-muted">5 menit</small>
                                </div>
                                <p class="text-muted small mb-0">Budi Santoso telah terdaftar sebagai anggota Divisi HUMAS.</p>
                            </div>
                        </div>
                        <div class="activity-item d-flex align-items-start mb-3 p-3 rounded-3">
                            <div class="bg-success-subtle rounded-circle p-2 me-3 flex-shrink-0">
                                <i class="fas fa-calendar-check text-success small"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <p class="mb-0 fw-semibold small">Kegiatan selesai</p>
                                    <small class="text-muted">1 jam</small>
                                </div>
                                <p class="text-muted small mb-0">Rapat Pleno telah berakhir dengan sukses.</p>
                            </div>
                        </div>
                        <div class="activity-item d-flex align-items-start mb-0 p-3 rounded-3">
                            <div class="bg-warning-subtle rounded-circle p-2 me-3 flex-shrink-0">
                                <i class="fas fa-edit text-warning small"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <p class="mb-0 fw-semibold small">Data diperbarui</p>
                                    <small class="text-muted">3 jam</small>
                                </div>
                                <p class="text-muted small mb-0">Admin telah mengubah jadwal kegiatan besok.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Info Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 rounded-3 bg-light">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-users-cog fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $adminCount }}</h6>
                                    <small class="text-muted">Admin Aktif</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 rounded-3 bg-light">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-check-double fa-2x text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-success">89%</h6>
                                    <small class="text-muted">Rata-rata Kehadiran</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Notifications & Quick Actions -->
        <div class="col-lg-4">
            <!-- Notifications Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold">
                            <i class="fas fa-bell me-2 text-warning"></i>Notifikasi
                        </h6>
                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1 pulse-indicator">3</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#" class="notification-item list-group-item list-group-item-action p-3 border-0 border-bottom d-flex align-items-center">
                            <div class="bg-primary-subtle rounded-3 p-3 text-primary me-3 flex-shrink-0">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-semibold small">Anggota Baru Bergabung</p>
                                <p class="mb-0 text-muted smaller">Budi Santoso telah terdaftar.</p>
                                <small class="text-muted">5 menit lalu</small>
                            </div>
                            <i class="fas fa-chevron-right chevron-animation text-muted ms-2"></i>
                        </a>
                        <a href="#" class="notification-item list-group-item list-group-item-action p-3 border-0 border-bottom d-flex align-items-center">
                            <div class="bg-success-subtle rounded-3 p-3 text-success me-3 flex-shrink-0">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-semibold small">Kegiatan Selesai</p>
                                <p class="mb-0 text-muted smaller">Rapat Pleno telah berakhir.</p>
                                <small class="text-muted">1 jam lalu</small>
                            </div>
                            <i class="fas fa-chevron-right chevron-animation text-muted ms-2"></i>
                        </a>
                        <a href="#" class="notification-item list-group-item list-group-item-action p-3 border-0 d-flex align-items-center">
                            <div class="bg-warning-subtle rounded-3 p-3 text-warning me-3 flex-shrink-0">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-semibold small">Pengingat Absensi</p>
                                <p class="mb-0 text-muted smaller">3 anggota belum melakukan absensi.</p>
                                <small class="text-muted">2 jam lalu</small>
                            </div>
                            <i class="fas fa-chevron-right chevron-animation text-muted ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pb-4 px-4">
                    <a href="#" class="btn btn-outline-primary w-100 rounded-3 quick-action-btn">
                        <i class="fas fa-eye me-1"></i> Lihat Semua Notifikasi
                    </a>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-bolt me-2 text-warning"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('anggota.create') }}" class="btn btn-primary rounded-3 py-2 shadow-sm quick-action-btn">
                            <i class="fas fa-user-plus me-2"></i> Tambah Anggota
                        </a>
                        <a href="{{ route('kegiatan.create') }}" class="btn btn-outline-primary rounded-3 py-2 quick-action-btn">
                            <i class="fas fa-calendar-plus me-2"></i> Buat Kegiatan
                        </a>
                        <a href="{{ route('absensi.index') }}" class="btn btn-outline-success rounded-3 py-2 quick-action-btn">
                            <i class="fas fa-clipboard-check me-2"></i> Kelola Absensi
                        </a>
                        <a href="{{ route('konten.create') }}" class="btn btn-outline-info rounded-3 py-2 quick-action-btn">
                            <i class="fas fa-upload me-2"></i> Upload Konten
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

