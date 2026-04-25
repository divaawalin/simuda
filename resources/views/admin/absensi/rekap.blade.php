@extends('layouts.app')

@section('page-title', 'Rekap Absensi: ' . ($kegiatan->nama_kegiatan ?? 'Kegiatan'))

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-square-poll-vertical"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Rekap Absensi Kegiatan</h4>
                    <p>{{ $kegiatan->nama_kegiatan ?? 'Kegiatan' }} - {{ \Carbon\Carbon::parse($kegiatan->tanggal ?? now())->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards Row 1: Core Stats --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <small class="text-uppercase fw-bold text-muted">Total Diundang</small>
                        <i class="fas fa-users" style="color: var(--primary-color); font-size: 1.25rem;"></i>
                    </div>
                    <div class="display-5 fw-bold" style="font-size:2.2rem;color:var(--primary-color);">{{ $summary['total_invited'] ?? 0 }}</div>
                    <small class="text-muted">Peserta terdaftar</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <small class="text-uppercase fw-bold text-muted">Hadir</small>
                        <i class="fas fa-user-check" style="color: #22c55e; font-size: 1.25rem;"></i>
                    </div>
                    <div class="display-5 fw-bold text-success" style="font-size:2.2rem;">{{ $summary['total_hadir'] ?? 0 }}</div>
                    @php $pct = ($summary['total_invited'] ?? 0) > 0 ? round(($summary['total_hadir'] / $summary['total_invited']) * 100, 1) : 0; @endphp
                    <small class="text-muted">{{ $pct }}% dari total</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <small class="text-uppercase fw-bold text-muted">Izin / Sakit</small>
                        <i class="fas fa-calendar-check" style="color: #eab308; font-size: 1.25rem;"></i>
                    </div>
                    <div class="display-5 fw-bold" style="font-size:2.2rem;color:#eab308;">{{ $summary['total_izin'] ?? 0 }}</div>
                    @php $pctIzin = ($summary['total_invited'] ?? 0) > 0 ? round(($summary['total_izin'] / $summary['total_invited']) * 100, 1) : 0; @endphp
                    <small class="text-muted">{{ $pctIzin }}% dari total</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <small class="text-uppercase fw-bold text-muted">Alfa</small>
                        <i class="fas fa-user-times" style="color: #ef4444; font-size: 1.25rem;"></i>
                    </div>
                    <div class="display-5 fw-bold text-danger" style="font-size:2.2rem;">{{ $summary['total_alfa'] ?? 0 }}</div>
                    @php $pctAlfa = ($summary['total_invited'] ?? 0) > 0 ? round(($summary['total_alfa'] / $summary['total_invited']) * 100, 1) : 0; @endphp
                    <small class="text-muted">{{ $pctAlfa }}% dari total</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards Row 2: Session & Division --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <small class="text-uppercase fw-bold text-muted">Hadir Sesi Mulai</small>
                        <i class="fas fa-play-circle" style="color: #3b82f6; font-size: 1.25rem;"></i>
                    </div>
                    <div class="display-5 fw-bold" style="font-size:2.2rem;color:#3b82f6;">{{ $summary['mulai_hadir'] ?? 0 }}</div>
                    <small class="text-muted">Dari {{ $summary['total_invited'] ?? 0 }} peserta</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <small class="text-uppercase fw-bold text-muted">Hadir Sesi Selesai</small>
                        <i class="fas fa-flag-checkered" style="color: #8b5cf6; font-size: 1.25rem;"></i>
                    </div>
                    <div class="display-5 fw-bold" style="font-size:2.2rem;color:#8b5cf6;">{{ $summary['selesai_hadir'] ?? 0 }}</div>
                    <small class="text-muted">Dari {{ $summary['total_invited'] ?? 0 }} peserta</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <small class="text-uppercase fw-bold text-muted">Divisi Terbaik</small>
                        <i class="fas fa-award" style="color: #f59e0b; font-size: 1.25rem;"></i>
                    </div>
                    @php $bestDiv = $summary['best_divisi'] ?? null; @endphp
                    <div class="fw-bold text-dark mb-1" style="font-size:1.3rem;">{{ $bestDiv ? $bestDiv['divisi'] : '-' }}</div>
                    <div class="badge bg-success-subtle fs-6 mb-2">{{ $bestDiv ? $bestDiv['percentage'] . '%' : '-' }}</div>
                    <small class="text-muted">{{ $bestDiv ? $bestDiv['hadir'] . ' dari ' . $bestDiv['total'] . ' orang' : '' }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row: Side by Side --}}
    <div class="row g-4 mb-4">
        {{-- Stacked Bar Chart: Session Attendance --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-bar me-2" style="color: var(--primary-color);"></i>Distribusi Kehadiran per Sesi</h5>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 400px; width: 100%;">
                        <canvas id="sessionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Horizontal Bar Chart: Attendance by Division --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-sitemap me-2" style="color: var(--primary-color);"></i>Kehadiran per Divisi</h5>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 400px; width: 100%;">
                        <canvas id="divisionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Table Full Width --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-users me-2" style="color: var(--primary-color);"></i>Detail Kehadiran Anggota</h5>
        </div>
        <div class="card-body p-4">
            {{-- Table Search --}}
            <div class="mb-3">
                <input type="text" id="searchTable" class="form-control rounded-3" placeholder="Cari nama atau divisi..." style="max-width: 300px;">
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="attendanceTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Nama Anggota</th>
                            <th>Divisi</th>
                            <th class="text-center">Sesi Mulai</th>
                            <th class="text-center">Sesi Selesai</th>
                            <th class="text-center">Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invited_users as $index => $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 + ($invited_users->currentPage() - 1) * $invited_users->perPage() }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2" style="background-color: var(--primary-color)20; color: var(--primary-color);">
                                    {{ $user->divisi }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($user->absen_mulai)
                                    <span class="badge bg-success">{{ \Carbon\Carbon::parse($user->absen_mulai->waktu_absen)->format('H:i') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($user->absen_selesai)
                                    <span class="badge bg-success">{{ \Carbon\Carbon::parse($user->absen_selesai->waktu_absen)->format('H:i') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 py-2 {{ ($user->attendance_percentage ?? 0) >= 75 ? 'bg-success-subtle' : (($user->attendance_percentage ?? 0) >= 50 ? 'bg-warning text-dark' : 'bg-danger-subtle') }}">
                                    {{ round($user->attendance_percentage ?? 0, 1) }}%
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada anggota yang diabsen untuk kegiatan ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $invited_users->appends(request()->query())->links() }}
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
            izin: { bg: 'rgba(234, 179, 8, 0.85)', border: 'rgba(234, 179, 8, 1)' }
        };

        // Stacked Bar: Sesi Mulai vs Selesai
        const ctxSession = document.getElementById('sessionChart').getContext('2d');
        new Chart(ctxSession, {
            type: 'bar',
            data: {
                labels: ['Sesi Mulai', 'Sesi Selesai'],
                datasets: [
                    {
                        label: 'Hadir',
                        data: [{{ $summary['mulai_hadir'] ?? 0 }}, {{ $summary['selesai_hadir'] ?? 0 }}],
                        backgroundColor: colors.hadir.bg,
                        borderColor: colors.hadir.border,
                        borderWidth: 1,
                        stack: 'status'
                    },
                    {
                        label: 'Izin/Sakit',
                        data: [
                            {{ ($summary['total_invited'] ?? 0) - ($summary['mulai_hadir'] ?? 0) }},
                            {{ ($summary['total_invited'] ?? 0) - ($summary['selesai_hadir'] ?? 0) }}
                        ],
                        backgroundColor: colors.izin.bg,
                        borderColor: colors.izin.border,
                        borderWidth: 1,
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
                                const total = {{ $summary['total_invited'] ?? 0 }};
                                const value = context.parsed.y;
                                const percent = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${context.dataset.label}: ${value} orang (${percent}%)`;
                            }
                        }
                    }
                },
                scales: {
                    x: { stacked: true, title: { display: true, text: 'Sesi' } },
                    y: { stacked: true, title: { display: true, text: 'Jumlah' }, beginAtZero: true }
                }
            }
        });

        // Horizontal Bar: Division
        const divisiLabels = @json($divisiStats->pluck('divisi')->toArray());
        const divisiPercent = @json($divisiStats->pluck('percentage')->toArray());
        const divisiTotal = @json($divisiStats->pluck('total')->toArray());
        const divisiHadir = @json($divisiStats->pluck('hadir')->toArray());

        const ctxDiv = document.getElementById('divisionChart').getContext('2d');
        new Chart(ctxDiv, {
            type: 'bar',
            data: {
                labels: divisiLabels,
                datasets: [{
                    label: 'Kehadiran (%)',
                    data: divisiPercent,
                    backgroundColor: 'rgba(4, 142, 142, 0.75)',
                    borderColor: 'rgba(4, 142, 142, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                return `Hadir: ${divisiHadir[idx]} dari ${divisiTotal[idx]} orang (${context.parsed.x}%)`;
                            }
                        }
                    }
                },
                scales: {
                    x: { beginAtZero: true, max: 100, title: { display: true, text: 'Persentase (%)' } },
                    y: { title: { display: true, text: 'Divisi' } }
                }
            }
        });

        // Table search
        const searchInput = document.getElementById('searchTable');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const value = this.value.toLowerCase();
                document.querySelectorAll('#attendanceTable tbody tr').forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(value) ? '' : 'none';
                });
            });
        }
    });
</script>
@endpush
