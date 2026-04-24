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

<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Command Center Admin</h4>
                    <p>Ringkasan operasional organisasi untuk {{ auth()->user()->name }} pada {{ now()->translatedFormat('d F Y') }}.</p>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge rounded-pill px-3 py-2 text-white border border-light-subtle">Live Overview</span>
                <span class="badge rounded-pill px-3 py-2 text-white border border-light-subtle">Panel Harian</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xxl-8">
            <div class="card border-0 rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 p-lg-5">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-7">
                            <span class="auth-eyebrow mb-3" style="display:inline-flex;">Dashboard Utama</span>
                            <h2 class="fw-bold text-dark mb-3" style="letter-spacing:-0.04em;">Semua titik penting organisasi ada dalam satu layar.</h2>
                            <p class="text-muted mb-4">Pantau pertumbuhan anggota, agenda, distribusi konten, dan kehadiran tanpa pindah konteks. Halaman ini saya susun seperti ruang kontrol, bukan daftar widget biasa.</p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('kegiatan.index') }}" class="btn btn-primary px-4">
                                    <i class="fas fa-calendar-alt me-2"></i>Kelola Kegiatan
                                </a>
                                <a href="{{ route('absensi.index') }}" class="btn btn-outline-primary px-4">
                                    <i class="fas fa-clipboard-check me-2"></i>Kelola Absensi
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="soft-card p-4 h-100 position-relative overflow-hidden">
                                <div class="corner-decoration corner-tl"></div>
                                <div class="corner-decoration corner-br"></div>
                                <div class="position-relative">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <small class="text-uppercase fw-bold text-muted d-block mb-1">Jam Server</small>
                                            <h3 class="fw-bold mb-0" id="clock">--:--</h3>
                                        </div>
                                        <div class="page-banner-icon" style="width:56px;height:56px;color:var(--primary-color);background:rgba(4,142,142,.08);">
                                            <i class="fas fa-wave-square"></i>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="p-3 rounded-4" style="background:rgba(4,142,142,.06);">
                                                <small class="text-muted d-block mb-1">Admin Aktif</small>
                                                <strong class="fs-4">{{ $adminCount }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3 rounded-4" style="background:rgba(95,198,215,.10);">
                                                <small class="text-muted d-block mb-1">Konten Tersedia</small>
                                                <strong class="fs-4">{{ $kontenCount }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="p-3 rounded-4" style="background:linear-gradient(135deg, rgba(4,142,142,.08), rgba(95,198,215,.12));">
                                                <small class="text-muted d-block mb-1">Kehadiran Hari Ini</small>
                                                <strong class="fs-4">{{ $absensiHariIni ?? 0 }} Check-in</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card border-0 rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <small class="text-uppercase fw-bold text-muted d-block mb-1">Aksi Cepat</small>
                            <h5 class="fw-bold mb-0">Mulai pekerjaan berikutnya</h5>
                        </div>
                        <div class="page-banner-icon" style="width:56px;height:56px;color:var(--secondary-color);background:rgba(95,198,215,.10);">
                            <i class="fas fa-bolt"></i>
                        </div>
                    </div>
                    <div class="d-grid gap-3">
                        <a href="{{ route('anggota.create') }}" class="soft-card p-3 text-decoration-none text-dark">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <strong class="d-block mb-1">Tambah Anggota</strong>
                                    <small class="text-muted">Buat entri anggota baru.</small>
                                </div>
                                <i class="fas fa-user-plus" style="color:var(--primary-color);"></i>
                            </div>
                        </a>
                        <a href="{{ route('kegiatan.create') }}" class="soft-card p-3 text-decoration-none text-dark">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <strong class="d-block mb-1">Buat Kegiatan</strong>
                                    <small class="text-muted">Susun agenda baru organisasi.</small>
                                </div>
                                <i class="fas fa-calendar-plus" style="color:var(--secondary-color);"></i>
                            </div>
                        </a>
                        <a href="{{ route('konten.create') }}" class="soft-card p-3 text-decoration-none text-dark">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <strong class="d-block mb-1">Upload Konten</strong>
                                    <small class="text-muted">Bagikan materi untuk anggota.</small>
                                </div>
                                <i class="fas fa-cloud-arrow-up" style="color:var(--primary-color);"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 rounded-4">
                <div class="card-header border-0 bg-transparent">
                    <h5 class="fw-bold mb-0"><i class="fas fa-chart-line me-2" style="color: var(--primary-color);"></i>Tren Kegiatan & Absensi</h5>
                </div>
                <div class="card-body">
                    <canvas id="trenChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 rounded-4 h-100">
                <div class="card-header border-0 bg-transparent">
                    <h5 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2" style="color: var(--secondary-color);"></i>Kalender Kegiatan</h5>
                </div>
                <div class="card-body">
                    <div id="calendar" style="max-height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-lg-8">
            <div class="row g-4">
                @foreach ([
                    ['title' => 'Total Anggota', 'value' => $totalAnggota ?? 0, 'icon' => 'fa-users', 'tone' => 'rgba(4,142,142,.08)', 'icon_color' => 'var(--primary-color)'],
                    ['title' => 'Total Kegiatan', 'value' => $totalKegiatan ?? 0, 'icon' => 'fa-calendar-check', 'tone' => 'rgba(95,198,215,.12)', 'icon_color' => 'var(--secondary-color)'],
                    ['title' => 'Hadir Hari Ini', 'value' => $absensiHariIni ?? 0, 'icon' => 'fa-user-check', 'tone' => 'rgba(4,142,142,.08)', 'icon_color' => 'var(--primary-color)'],
                    ['title' => 'Total Konten', 'value' => $kontenCount, 'icon' => 'fa-layer-group', 'tone' => 'rgba(95,198,215,.12)', 'icon_color' => 'var(--secondary-color)']
                ] as $stat)
                <div class="col-md-6">
                    <div class="card border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <small class="text-uppercase fw-bold text-muted d-block mb-2">{{ $stat['title'] }}</small>
                                    <div class="display-6 mb-2" style="font-size:2.3rem;font-weight:800;line-height:1;">{{ $stat['value'] }}</div>
                                    <span class="text-muted small">Terpantau langsung dari data sistem.</span>
                                </div>
                                <div class="page-banner-icon" style="width:60px;height:60px;background:{{ $stat['tone'] }};color:{{ $stat['icon_color'] }};">
                                    <i class="fas {{ $stat['icon'] }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 rounded-4 h-100">
                <div class="card-header border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-signal me-2" style="color: var(--primary-color);"></i>Alur Operasional</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <div class="soft-card p-3">
                            <small class="text-uppercase fw-bold text-muted d-block mb-2">01</small>
                            <strong class="d-block mb-1">Susun agenda</strong>
                            <span class="text-muted small">Kegiatan jadi pusat absensi dan undangan.</span>
                        </div>
                        <div class="soft-card p-3">
                            <small class="text-uppercase fw-bold text-muted d-block mb-2">02</small>
                            <strong class="d-block mb-1">Invite anggota</strong>
                            <span class="text-muted small">Pilih siapa yang berhak mengikuti sesi absensi.</span>
                        </div>
                        <div class="soft-card p-3">
                            <small class="text-uppercase fw-bold text-muted d-block mb-2">03</small>
                            <strong class="d-block mb-1">Lihat rekap</strong>
                            <span class="text-muted small">Evaluasi kehadiran mulai dan selesai untuk setiap anggota.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    // Clock
    function updateClock() {
        document.getElementById('clock').innerText = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
    }
    updateClock();
    setInterval(updateClock, 1000);

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
                    borderColor: '#048e8e',
                    backgroundColor: 'rgba(4,142,142,0.1)',
                    tension: 0.4
                },
                {
                    label: 'Absensi',
                    data: {{ Js::from($absensiData) }},
                    borderColor: '#5fc6d7',
                    backgroundColor: 'rgba(95,198,215,0.1)',
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
