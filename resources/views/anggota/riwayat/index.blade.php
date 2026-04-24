@extends('layouts.app')

@section('page-title', 'Riwayat Absensi')

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-chart-line fa-3x text-primary"></i>
                    </div>
                    <h3 class="fw-bold text-primary">{{ $persentase }}%</h3>
                    <p class="text-muted">Presentase Kehadiran</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <span><i class="fas fa-chart-bar me-2"></i>Statistik</span>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Hadir:</span>
                        <span class="fw-bold text-success">{{ $totalHadir }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Total Sesi:</span>
                        <span class="fw-bold">{{ $totalSesi }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <span><i class="fas fa-history me-2"></i>Riwayat Absensi</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Tipe Sesi</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $absen)
                                <tr>
                                    <td>{{ optional($absen->kegiatan)->nama_kegiatan ?? 'Deleted' }}</td>
                                    <td>
                                        @if($absen->tipe_sesi == 'mulai')
                                            <span class="badge bg-info">Mulai</span>
                                        @else
                                            <span class="badge bg-warning">Selesai</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($absen->waktu_absen)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($absen->status == 'hadir')
                                            <span class="badge bg-success">Hadir</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Hadir</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada riwayat absensi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $riwayat->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
