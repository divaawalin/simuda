@extends('layouts.app')

@section('page-title', 'Rekap Absensi')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm p-4 mb-4 rounded-4" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
        <div class="d-flex align-items-center">
            <div class="text-white p-3 rounded-4 me-4" style="background-color: rgba(255, 255, 255, 0.15);">
                <i class="fas fa-list-alt fa-2x"></i>
            </div>
            <div>
                <h4 class="fw-bold text-white mb-1">Rekap Absensi Kegiatan</h4>
                <p class="text-white-50 small mb-0">{{ $kegiatan->nama_kegiatan }}</p>
            </div>
        </div>
    </div>

    <!-- Attendance Details Card -->
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
                                    $statusMulaiColor = $user->absen_mulai ? 'var(--success)' : '#dc3545';
                                    $statusSelesaiColor = $user->absen_selesai ? 'var(--success)' : '#dc3545';
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
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada anggota yang diabsen untuk kegiatan ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
