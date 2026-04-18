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
                    <p>Statistik kehadiran seluruh kegiatan per tahun/bulan.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-filter me-2" style="color: var(--primary-color);"></i>Filter Data</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('absensi.rekapGlobal') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="year" class="form-label">Tahun</label>
                        <select name="year" id="year" class="form-select">
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="month" class="form-label">Bulan</label>
                        <select name="month" id="month" class="form-select">
                            <option value="">Semua Bulan</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 rounded-4">
                <div class="card-body p-4">
                    <small class="text-uppercase fw-bold text-muted d-block mb-2">Total Persentase Kehadiran Global</small>
                    <div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ round($overallGlobalPercentage, 2) }}%</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-pie me-2" style="color: var(--primary-color);"></i>Ringkasan Kehadiran Global</h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="overallGlobalChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Diagram Kehadiran per Kegiatan --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-bar me-2" style="color: var(--primary-color);"></i>Diagram Persentase Kehadiran per Kegiatan</h5>
        </div>
        <div class="card-body p-4">
            <canvas id="activityAttendanceChart" width="400" height="200"></canvas>
        </div>
    </div>

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
                            <th>Tanggal Kegiatan</th>
                            <th>Total Diundang</th>
                            <th>Total Hadir</th>
                            <th>Persentase Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $item)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item['kegiatan']->nama_kegiatan }}</div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item['kegiatan']->tanggal_keg)->format('d M Y') }}</td>
                            <td>{{ $item['total_invited'] }}</td>
                            <td>{{ $item['total_attended'] }}</td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 {{ $item['attendance_percentage'] >= 75 ? 'bg-success' : ($item['attendance_percentage'] >= 50 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ round($item['attendance_percentage'], 2) }}%
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Tidak ada data absensi untuk periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data for Activity Attendance Chart
        const activityLabels = @json(collect($data)->pluck('kegiatan.nama_kegiatan'));
        const activityPercentages = @json(collect($data)->pluck('attendance_percentage'));

        const activityCtx = document.getElementById('activityAttendanceChart').getContext('2d');
        const activityAttendanceChart = new Chart(activityCtx, {
            type: 'bar',
            data: {
                labels: activityLabels,
                datasets: [{
                    label: 'Persentase Kehadiran per Kegiatan (%)',
                    data: activityPercentages,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Persentase (%)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Nama Kegiatan'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y + '%';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Data for Overall Global Chart (Pie Chart)
        const overallGlobalPercentage = {{ round($overallGlobalPercentage, 2) }};
        const remainingPercentage = 100 - overallGlobalPercentage;

        const overallGlobalCtx = document.getElementById('overallGlobalChart').getContext('2d');
        new Chart(overallGlobalCtx, {
            type: 'pie',
            data: {
                labels: ['Hadir', 'Tidak Hadir'],
                datasets: [{
                    data: [overallGlobalPercentage, remainingPercentage],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.7)', // Green for Hadir
                        'rgba(220, 53, 69, 0.7)'  // Red for Tidak Hadir
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Ringkasan Kehadiran Global'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed.toFixed(2) + '%';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
