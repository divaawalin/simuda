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

<div class="dashboard-container">
    {{-- Hero Premium --}}
    <div class="hero-premium mb-4">
        <div class="hero-content">
            <div class="hero-logo">
                <div class="hero-logo-icon">
                    <i class="fas fa-mosque"></i>
                </div>
            </div>
            <div class="hero-text">
                <div class="hero-greeting">
                    Selamat Datang, {{ auth()->user()->name }} 👋
                </div>
                <h1 class="hero-title">GENERUS JEMBER</h1>
                <p class="hero-subtitle">Pantau pertumbuhan anggota, agenda, distribusi konten, dan kehadiran tanpa pindah konteks.</p>
            </div>
            <div class="hero-badges">
                <span class="hero-badge">Live Overview</span>
                <span class="hero-badge">Panel Harian</span>
            </div>
        </div>
    </div>

    {{-- Stats Cards 2x2 Compact --}}
    <div class="row g-3 mb-4">
        @foreach ([
            ['title' => 'Total Anggota', 'value' => $totalAnggota ?? 0, 'icon' => 'fa-users', 'bg' => 'rgba(15, 159, 165, 0.1)', 'icon_color' => 'var(--primary-color)'],
            ['title' => 'Total Kegiatan', 'value' => $totalKegiatan ?? 0, 'icon' => 'fa-calendar-check', 'bg' => 'rgba(51, 196, 214, 0.12)', 'icon_color' => 'var(--secondary-color)'],
            ['title' => 'Hadir Hari Ini', 'value' => $absensiHariIni ?? 0, 'icon' => 'fa-user-check', 'bg' => 'rgba(15, 159, 165, 0.1)', 'icon_color' => 'var(--primary-color)'],
            ['title' => 'Total Konten', 'value' => $kontenCount, 'icon' => 'fa-layer-group', 'bg' => 'rgba(51, 196, 214, 0.12)', 'icon_color' => 'var(--secondary-color)']
        ] as $stat)
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card-premium h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-wrapper" style="background: {{ $stat['bg'] }}; color: {{ $stat['icon_color'] }};">
                                <i class="fas {{ $stat['icon'] }}"></i>
                            </div>
                            <div>
                                <div class="stat-value">{{ $stat['value'] }}</div>
                                <div class="stat-label">{{ $stat['title'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Chart + Calendar 6:6 Ratio --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card stat-card-premium h-100">
                <div class="card-header border-0 bg-transparent py-3 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-chart-line me-2" style="color: var(--primary-color);"></i>Tren Kegiatan & Absensi</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="trenChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card stat-card-premium h-100">
                <div class="card-header border-0 bg-transparent py-3 px-4">
                    <h6 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2" style="color: var(--secondary-color);"></i>Kalender Kegiatan</h6>
                </div>
                <div class="card-body p-3">
                    <div id="calendar" style="max-height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions 3 Columns --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <a href="{{ route('admin.anggota.create') }}" class="action-card h-100">
                <div class="action-card-icon" style="background: rgba(15, 159, 165, 0.1); color: var(--primary-color);">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="action-card-title">Tambah Anggota</div>
                <div class="action-card-desc">Buat entri anggota baru.</div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="{{ route('admin.kegiatan.create') }}" class="action-card h-100">
                <div class="action-card-icon" style="background: rgba(51, 196, 214, 0.12); color: var(--secondary-color);">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <div class="action-card-title">Buat Kegiatan</div>
                <div class="action-card-desc">Susun agenda baru organisasi.</div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="{{ route('admin.konten.create') }}" class="action-card h-100">
                <div class="action-card-icon" style="background: rgba(15, 159, 165, 0.1); color: var(--primary-color);">
                    <i class="fas fa-cloud-arrow-up"></i>
                </div>
                <div class="action-card-title">Upload Konten</div>
                <div class="action-card-desc">Bagikan materi untuk anggota.</div>
            </a>
        </div>
    </div>

    {{-- Operational Flow 3 Columns --}}
    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card stat-card-premium h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="flow-number">01</span>
                        <strong class="flow-title">Susun agenda</strong>
                    </div>
                    <div class="flow-desc">Kegiatan jadi pusat absensi dan undangan.</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card stat-card-premium h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="flow-number">02</span>
                        <strong class="flow-title">Invite anggota</strong>
                    </div>
                    <div class="flow-desc">Pilih siapa yang berhak mengikuti sesi absensi.</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card stat-card-premium h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="flow-number">03</span>
                        <strong class="flow-title">Lihat rekap</strong>
                    </div>
                    <div class="flow-desc">Evaluasi kehadiran mulai dan selesai untuk setiap anggota.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    // Chart.js
    const ctx = document.getElementById('trenChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {{ Js::from($labels) }},
            datasets: [
                {
                    label: 'Kegiatan',
                    data: {{ Js::from($kegiatanData) }},
                    borderColor: '#0F9FA5',
                    backgroundColor: 'rgba(15, 159, 165, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Absensi',
                    data: {{ Js::from($absensiData) }},
                    borderColor: '#33C4D6',
                    backgroundColor: 'rgba(51, 196, 214, 0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // FullCalendar
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: {!! App\Models\Kegiatan::all()->map(fn($k) => ['title' => $k->nama_kegiatan, 'start' => $k->tanggal])->toJson() !!}
    });
    calendar.render();
</script>
@endsection
