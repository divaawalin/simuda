@extends('layouts.app')

@section('page-title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-primary-subtle rounded-3 p-3 text-primary">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-0 fw-semibold">Total Anggota</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalAnggota }}</h3>
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100" style="border-left: 4px solid var(--secondary-color) !important;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-info-subtle rounded-3 p-3 text-info" style="background-color: rgba(95, 198, 215, 0.1) !important; color: #5FC6D7 !important;">
                        <i class="fas fa-calendar-check fa-2x"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-0 fw-semibold">Total Kegiatan</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalKegiatan }}</h3>
                    </div>
                </div>
                <div class="icon" style="color: #5FC6D7 !important;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width: 45%; background-color: #5FC6D7 !important;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0 bg-success-subtle rounded-3 p-3 text-success">
                        <i class="fas fa-user-clock fa-2x"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-0 fw-semibold">Absensi Hari Ini</h6>
                        <h3 class="mb-0 fw-bold">{{ $absensiHariIni }}</h3>
                    </div>
                </div>
                <div class="icon" style="color: #2ECC71 !important;">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="progress mt-3" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold"><i class="fas fa-chart-line me-2 text-primary"></i>Ringkasan Aktivitas</h6>
                <div class="dropdown">
                    <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                        <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center py-5">
                    <h5 class="fw-bold">Selamat datang kembali, Admin!</h5>
                    <p class="text-muted px-lg-5">Gunakan menu di sebelah kiri untuk mengelola data anggota, kegiatan, dan memantau absensi organisasi Anda secara real-time.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header">
                <h6 class="m-0 fw-bold"><i class="fas fa-bell me-2 text-warning"></i>Notifikasi Terkini</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item p-3 border-0 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-subtle rounded-circle p-2 text-primary me-3">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <p class="mb-0 fw-semibold small">Anggota Baru Bergabung</p>
                                <p class="mb-0 text-muted smaller">Budi Santoso telah terdaftar.</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item p-3 border-0 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-success-subtle rounded-circle p-2 text-success me-3">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="mb-0 fw-semibold small">Kegiatan Selesai</p>
                                <p class="mb-0 text-muted smaller">Rapat Pleno telah berakhir.</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item p-3 border-0">
                        <div class="d-flex align-items-center text-center w-100 justify-content-center">
                            <a href="#" class="text-primary fw-bold small text-decoration-none">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
