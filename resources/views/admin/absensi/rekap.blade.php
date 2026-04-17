@extends('layouts.app')

@section('page-title', 'Rekap Absensi')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 bg-primary text-white">
            <div class="d-flex align-items-center">
                <div class="bg-white p-3 rounded-4 text-primary me-4">
                    <i class="fas fa-list-alt fa-2x"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-1">Rekap Absensi Kegiatan</h4>
                    <p class="mb-0 opacity-75">{{ $kegiatan->nama_kegiatan }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header py-3">
        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-users-cog me-2"></i>Detail Kehadiran</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
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
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <p class="mb-0 fw-bold">{{ $user->name }}</p>
                            <small class="text-muted">{{ $user->email }}</small>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle rounded-pill">{{ $user->divisi }}</span>
                        </td>
                        <td>
                            @if($user->absen_mulai)
                                <span class="badge bg-success-subtle">Hadir</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger">Tidak Hadir</span>
                            @endif
                        </td>
                        <td>
                            @if($user->absen_mulai)
                                <small>{{ $user->absen_mulai->waktu_absen->format('H:i:s d M Y') }}</small>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                        <td>
                            @if($user->absen_selesai)
                                <span class="badge bg-success-subtle">Hadir</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger">Tidak Hadir</span>
                            @endif
                        </td>
                        <td>
                            @if($user->absen_selesai)
                                <small>{{ $user->absen_selesai->waktu_absen->format('H:i:s d M Y') }}</small>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3 opacity-20"></i>
                            <p class="text-muted">Belum ada anggota yang diundang atau diabsen untuk kegiatan ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
