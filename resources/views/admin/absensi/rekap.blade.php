@extends('layouts.app')

@section('page-title', 'Rekap Absensi')

@section('content')
<div class="container-fluid px-0">
    @php
        $mulaiHadir = $invited_users->filter(fn ($user) => !is_null($user->absen_mulai))->count();
        $selesaiHadir = $invited_users->filter(fn ($user) => !is_null($user->absen_selesai))->count();
    @endphp

    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-square-poll-vertical"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Rekap Absensi Kegiatan</h4>
                    <p>{{ $kegiatan->nama_kegiatan }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Diundang</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $invited_users->count() }}</div></div></div></div>
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Hadir Sesi Mulai</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $mulaiHadir }}</div></div></div></div>
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Hadir Sesi Selesai</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $selesaiHadir }}</div></div></div></div>
    </div>

    {{-- Diagram Kehadiran --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-chart-bar me-2" style="color: var(--primary-color);"></i>Diagram Persentase Kehadiran</h5>
        </div>
        <div class="card-body p-4">
            <canvas id="attendanceChart" width="400" height="200"></canvas>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-users-cog me-2" style="color: var(--primary-color);"></i>Detail Kehadiran</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Nama Anggota</th>
                            <th>Divisi</th>
                            <th>Status Mulai</th>
                            <th>Waktu Mulai</th>
                            <th>Status Selesai</th>
                            <th>Waktu Selesai</th>
                            <th>Persentase Kehadiran</th> {{-- New column header --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invited_users as $index => $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2" style="background-color: var(--primary-color)20; color: var(--primary-color);">
                                    {{ $user->divisi }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusMulaiColor = $user->absen_mulai ? '#27ae60' : '#dc3545';
                                    $statusSelesaiColor = $user->absen_selesai ? '#27ae60' : '#dc3545';
                                @endphp
                                <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $statusMulaiColor }}20; color: {{ $statusMulaiColor }};">
                                    {{ $user->absen_mulai ? 'Hadir' : 'Tidak Hadir' }}
                                </span>
                            </td>
                            <td>
                                @if($user->absen_mulai)
                                    {{ \Carbon\Carbon::parse($user->absen_mulai->waktu_absen)->format('H:i:s d M Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $statusSelesaiColor }}20; color: {{ $statusSelesaiColor }};">
                                    {{ $user->absen_selesai ? 'Hadir' : 'Tidak Hadir' }}
                                </span>
                            </td>
                            <td>
                                @if($user->absen_selesai)
                                    {{ \Carbon\Carbon::parse($user->absen_selesai->waktu_absen)->format('H:i:s d M Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 {{ $user->attendance_percentage >= 75 ? 'bg-success' : ($user->attendance_percentage >= 50 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ round($user->attendance_percentage, 2) }}%
                                </span>
                            </td> {{-- New column data --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Belum ada anggota yang diabsen untuk kegiatan ini.</td> {{-- Adjusted colspan --}}
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $invited_users->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = @json($invited_users->pluck('name'));
        const data = @json($invited_users->pluck('attendance_percentage'));

        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Persentase Kehadiran (%)',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(255, 205, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(201, 203, 207, 0.5)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
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
                            text: 'Nama Anggota'
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
    });
</script>
@endpush

