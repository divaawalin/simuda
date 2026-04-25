@extends('layouts.app')

@section('page-title', 'Rekap Absensi Global')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Rekap Absensi Global</h4>
                    <p>Analisis kehadiran lengkap dengan breakdown status per kegiatan.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-filter me-2" style="color: var(--primary-color);"></i>Filter Data</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('absensi.rekapGlobal') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-4">
                        <label for="year" class="form-label">Tahun</label>
                        <select name="year" id="year" class="form-select">
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label for="month" class="form-label">Bulan</label>
                        <select name="month" id="month" class="form-select">
                            <option value="">Semua Bulan</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label for="division" class="form-label">Divisi</label>
                        <select name="division" id="division" class="form-select">
                            <option value="">Semua Divisi</option>
                            @foreach($divisions as $div)
                                <option value="{{ $div }}" {{ ($divisionFilter ?? request('division')) == $div ? 'selected' : '' }}>{{ $div }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label for="activity" class="form-label">Kegiatan</label>
                        <input type="text" name="activity" id="activity" class="form-control" placeholder="Cari nama kegiatan..." value="{{ $activityFilter ?? request('activity') }}">
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-4">Filter</button>
                        <a href="{{ route('absensi.rekapGlobal') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Row 1: Main KPIs --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="text-uppercase fw-bold text-muted">Rata-rata Kehadiran</small>
                        <i class="fas fa-percentage" style="color: var(--primary-color);"></i>
                    </div>
                    @php $avg = $summary['avg_attendance'] ?? 0; @endphp
                    <div class="display-5 fw-bold" style="font-size:2.2rem;color:var(--primary-color);">{{ is_numeric($avg) ? round($avg, 1) : 0 }}%</div>
                    <small class="text-muted">Keseluruhan kegiatan</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="text-uppercase fw-bold text-muted">Total Kegiatan</small>
                        <i class="fas fa-calendar-check" style="color: var(--secondary-color);"></i>
                    </div>
                    <div class="display-5 fw-bold" style="font-size:2.2rem;color:var(--secondary-color);">{{ $summary['total_kegiatan'] ?? 0 }}</div>
                    <small class="text-muted">Di periode ini</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="text-uppercase fw-bold text-muted">Total Peserta</small>
                        <i class="fas fa-users" style="color: #8b5cf6;"></i>
                    </div>
                    <div class="display-5 fw-bold" style="font-size:2.2rem;color:#8b5cf6;">{{ $summary['total_anggota'] ?? 0 }}</div>
                    <small class="text-muted">Anggota diundang</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="text-uppercase fw-bold text-muted">Kegiatan Terbaik</small>
                        <i class="fas fa-trophy" style="color: #f59e0b;"></i>
                    </div>
                    @php $best = $summary['best_kegiatan'] ?? null; @endphp
                    <div class="fw-bold text-dark mb-1" style="font-size:1.2rem;">{{ $best && isset($best['kegiatan']) ? Str::limit($best['kegiatan']->nama_kegiatan, 20) : '-' }}</div>
                    <div class="badge bg-success-subtle">{{ $best ? round($best['attendance_percentage'] ?? 0, 1) . '%' : '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Row 2: Additional Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="text-uppercase fw-bold text-muted">Kegiatan Terendah</small>
                        <i class="fas fa-arrow-down" style="color: #ef4444;"></i>
                    </div>
                    @php $worst = $summary['worst_kegiatan'] ?? null; @endphp
                    <div class="fw-bold text-dark mb-1" style="font-size:1.2rem;">{{ $worst && isset($worst['kegiatan']) ? Str::limit($worst['kegiatan']->nama_kegiatan, 20) : '-' }}</div>
                    <div class="badge bg-danger-subtle">{{ $worst ? round($worst['attendance_percentage'] ?? 0, 1) . '%' : '-' }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="text-uppercase fw-bold text-muted">Anggota Paling Rajin</small>
                        <i class="fas fa-crown" style="color: #f59e0b;"></i>
                    </div>
                    @php $top = $summary['top_attendee'] ?? null; @endphp
                    <div class="fw-bold text-dark mb-1" style="font-size:1.2rem;">{{ $top ? Str::limit($top->name, 20) : '-' }}</div>
                    <div class="mt-2"><span class="badge bg-success">{{ $top ? ($top->total_hadir ?? 0) . 'x hadir' : '-' }}</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="text-uppercase fw-bold text-muted">Alfa Terbanyak</small>
                        <i class="fas fa-exclamation-circle" style="color: #ef4444;"></i>
                    </div>
                    @php $topAlfa = $summary['top_alfa_member'] ?? null; @endphp
                    <div class="fw-bold text-dark mb-1" style="font-size:1.2rem;">{{ $topAlfa ? Str::limit($topAlfa->name, 20) : '-' }}</div>
                    <div class="mt-2"><span class="badge bg-danger">{{ $topAlfa ? ($topAlfa->total_alfa ?? 0) . 'x alfa' : '-' }}</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row 1: Overview --}}
    <div class="row g-4 mb-4">
        {{-- Overall Donut Chart --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-pie me-2" style="color: var(--primary-color);"></i>Distribusi Kehadiran Global</h5>
                </div>
                <div class="card-body p-4 d-flex align-items-center justify-content-center" style="min-height: 350px;">
                    <canvas id="overallDonutChart" style="max-height: 350px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        {{-- Status Breakdown Summary --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-bar me-2" style="color: var(--primary-color);"></i>Ringkasan Status Global</h5>
                </div>
                <div class="card-body p-4 d-flex align-items-center justify-content-center">
                    <div class="row g-4 w-100 justify-content-center">
                        <div class="col-4">
                            <div class="text-center">
                                <div class="fw-bold text-success mb-2" style="font-size:2rem;">{{ $overallHadirPercent ?? 0 }}%</div>
                                <small class="d-block text-muted mb-2">Hadir</small>
                                <span class="badge bg-success">{{ $totalOverallHadir ?? 0 }} orang</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center">
                                <div class="fw-bold mb-2" style="font-size:2rem;color:#eab308;">{{ $overallIzinPercent ?? 0 }}%</div>
                                <small class="d-block text-muted mb-2">Izin/Sakit</small>
                                <span class="badge bg-warning text-dark">{{ $totalOverallIzin ?? 0 }} orang</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center">
                                <div class="fw-bold text-danger mb-2" style="font-size:2rem;">{{ $overallAlfaPercent ?? 0 }}%</div>
                                <small class="d-block text-muted mb-2">Alfa</small>
                                <span class="badge bg-danger">{{ $totalOverallAlfa ?? 0 }} orang</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="row g-3 w-100">
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center" style="background: rgba(34, 197, 94, 0.08);">
                                <div class="fw-bold text-success mb-1" style="font-size:1.75rem;">{{ $overallHadirPercent ?? 0 }}%</div>
                                <small class="text-muted">Hadir</small>
                                <div class="mt-2"><span class="badge bg-success">{{ $totalOverallHadir ?? 0 }} orang</span></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center" style="background: rgba(234, 179, 8, 0.08);">
                                <div class="fw-bold mb-1" style="font-size:1.75rem;color:#eab308;">{{ $overallIzinPercent ?? 0 }}%</div>
                                <small class="text-muted">Izin/Sakit</small>
                                <div class="mt-2"><span class="badge bg-warning text-dark">{{ $totalOverallIzin ?? 0 }} orang</span></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3 text-center" style="background: rgba(239, 68, 68, 0.08);">
                                <div class="fw-bold text-danger mb-1" style="font-size:1.75rem;">{{ $overallAlfaPercent ?? 0 }}%</div>
                                <small class="text-muted">Alfa</small>
                                <div class="mt-2"><span class="badge bg-danger">{{ $totalOverallAlfa ?? 0 }} orang</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row 2: Per-Kegiatan & Monthly Trend --}}
    <div class="row g-4 mb-4">
        {{-- Stacked Horizontal Bar: Per Kegiatan --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-bar me-2" style="color: var(--primary-color);"></i>Persentase per Kegiatan</h5>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 500px; width: 100%;">
                        <canvas id="stackedAttendanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Monthly Trend Chart --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-line me-2" style="color: var(--primary-color);"></i>Tren Kehadiran Bulanan</h5>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 500px; width: 100%;">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row 3: Division Comparison --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-sitemap me-2" style="color: var(--primary-color);"></i>Perbandingan Kehadiran per Divisi</h5>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 400px; width: 100%;">
                        <canvas id="divisionComparisonChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Rekap Table Full Width --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-list me-2" style="color: var(--primary-color);"></i>Detail Rekap per Kegiatan</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal</th>
                            <th class="text-center">Diundang</th>
                            <th class="text-center">Hadir</th>
                            <th class="text-center">Izin</th>
                            <th class="text-center">Alfa</th>
                            <th class="text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $item)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 + ($data->currentPage() - 1) * $data->perPage() }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item['kegiatan']->nama_kegiatan }}</div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item['kegiatan']->tanggal)->format('d M Y') }}</td>
                            <td class="text-center"><span class="badge bg-secondary-subtle">{{ $item['total_invited'] }}</span></td>
                            <td class="text-center"><span class="badge bg-success">{{ $item['total_hadir'] ?? 0 }}</span></td>
                            <td class="text-center"><span class="badge bg-warning text-dark">{{ $item['total_izin'] ?? 0 }}</span></td>
                            <td class="text-center"><span class="badge bg-danger">{{ $item['total_alfa'] ?? 0 }}</span></td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 py-2 {{ ($item['attendance_percentage'] ?? 0) >= 75 ? 'bg-success-subtle' : (($item['attendance_percentage'] ?? 0) >= 50 ? 'bg-warning text-dark' : 'bg-danger-subtle') }}">
                                    {{ round($item['attendance_percentage'] ?? 0, 1) }}%
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Tidak ada data absensi untuk periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $data->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colors = {
            hadir: { bg: 'rgba(34, 197, 94, 0.85)', border: 'rgba(34, 197, 94, 1)' },
            izin: { bg: 'rgba(234, 179, 8, 0.85)', border: 'rgba(234, 179, 8, 1)' },
            alfa: { bg: 'rgba(239, 68, 68, 0.85)', border: 'rgba(239, 68, 68, 1)' }
        };

        // Prepare data
        const kegiatanLabels = @json($allRecapData->pluck('kegiatan.nama_kegiatan')->toArray());
        const hadirData = @json($allRecapData->pluck('total_hadir')->toArray());
        const izinData = @json($allRecapData->pluck('total_izin')->toArray());
        const alfaData = @json($allRecapData->pluck('total_alfa')->toArray());
        const invitedData = @json($allRecapData->pluck('total_invited')->toArray());

        const hadirPercent = @json($allRecapData->pluck('hadir_percent')->toArray());
        const izinPercent = @json($allRecapData->pluck('izin_percent')->toArray());
        const alfaPercent = @json($allRecapData->pluck('alfa_percent')->toArray());

        // Stacked Horizontal Bar Chart (per kegiatan)
        const ctxStacked = document.getElementById('stackedAttendanceChart').getContext('2d');
        new Chart(ctxStacked, {
            type: 'bar',
            data: {
                labels: kegiatanLabels,
                datasets: [
                    {
                        label: 'Hadir',
                        data: hadirPercent,
                        backgroundColor: colors.hadir.bg,
                        borderColor: colors.hadir.border,
                        borderWidth: 1,
                        stack: 'status'
                    },
                    {
                        label: 'Izin/Sakit',
                        data: izinPercent,
                        backgroundColor: colors.izin.bg,
                        borderColor: colors.izin.border,
                        borderWidth: 1,
                        stack: 'status'
                    },
                    {
                        label: 'Alfa',
                        data: alfaPercent,
                        backgroundColor: colors.alfa.bg,
                        borderColor: colors.alfa.border,
                        borderWidth: 1,
                        stack: 'status'
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 10 } },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                const label = context.dataset.label;
                                const percent = context.parsed.x;
                                const countMap = { 'Hadir': hadirData[idx], 'Izin/Sakit': izinData[idx], 'Alfa': alfaData[idx] };
                                const count = countMap[label] || 0;
                                return `${label}: ${percent}% (${count} orang)`;
                            }
                        }
                    }
                },
                scales: {
                    x: { stacked: true, max: 100, title: { display: true, text: 'Persentase (%)' } },
                    y: { stacked: true, title: { display: true, text: 'Kegiatan' } }
                }
            }
        });

        // Overall Donut Chart
        const ctxDonut = document.getElementById('overallDonutChart').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Izin/Sakit', 'Alfa'],
                datasets: [{
                    data: [{{ $overallHadirPercent ?? 0 }}, {{ $overallIzinPercent ?? 0 }}, {{ $overallAlfaPercent ?? 0 }}],
                    backgroundColor: [colors.hadir.bg, colors.izin.bg, colors.alfa.bg],
                    borderColor: [colors.hadir.border, colors.izin.border, colors.alfa.border],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed.toFixed(1) + '%';
                            }
                        }
                    }
                }
            }
        });

        // Monthly Trend Line Chart
        const monthlyTrend = @json($summary['monthly_trend'] ?? []);
        if (monthlyTrend && monthlyTrend.length > 0) {
            const trendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: monthlyTrend.map(m => m.month_name),
                    datasets: [
                        {
                            label: 'Kehadiran (%)',
                            data: monthlyTrend.map(m => m.percentage),
                            borderColor: 'rgba(4, 142, 142, 1)',
                            backgroundColor: 'rgba(4, 142, 142, 0.1)',
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Total Hadir',
                            data: monthlyTrend.map(m => m.hadir),
                            borderColor: 'rgba(34, 197, 94, 1)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            fill: true,
                            tension: 0.3,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (context.dataset.label.includes('Persentase')) {
                                        return `${context.dataset.label}: ${context.parsed.y}%`;
                                    }
                                    return `${context.dataset.label}: ${context.parsed.y} orang`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: { display: true, text: 'Persentase (%)' },
                            min: 0,
                            max: 100
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: { display: true, text: 'Jumlah Hadir' },
                            grid: { drawOnChartArea: false }
                        },
                        x: { title: { display: true, text: 'Bulan' } }
                    }
                }
            });
        }

        // Division Comparison Stacked Bar
        const divisionData = @json($summary['division_comparison'] ?? []);
        if (divisionData && divisionData.length > 0) {
            const divCtx = document.getElementById('divisionComparisonChart').getContext('2d');
            new Chart(divCtx, {
                type: 'bar',
                data: {
                    labels: divisionData.map(d => d.divisi),
                    datasets: [
                        {
                            label: 'Hadir',
                            data: divisionData.map(d => d.hadir),
                            backgroundColor: colors.hadir.bg,
                            borderColor: colors.hadir.border,
                            stack: 'status'
                        },
                        {
                            label: 'Izin/Sakit',
                            data: divisionData.map(d => d.izin),
                            backgroundColor: colors.izin.bg,
                            borderColor: colors.izin.border,
                            stack: 'status'
                        },
                        {
                            label: 'Alfa',
                            data: divisionData.map(d => d.alfa),
                            backgroundColor: colors.alfa.bg,
                            borderColor: colors.alfa.border,
                            stack: 'status'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 10 } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const idx = context.dataIndex;
                                    const invited = divisionData[idx].invited;
                                    const value = context.parsed.y;
                                    const percent = invited > 0 ? ((value / invited) * 100).toFixed(1) : 0;
                                    return `${context.dataset.label}: ${value} orang (${percent}%)`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: { stacked: true, title: { display: true, text: 'Divisi' } },
                        y: { stacked: true, title: { display: true, text: 'Jumlah' }, beginAtZero: true }
                    }
                }
            });
        }
    });
</script>
@endpush
