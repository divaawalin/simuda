@extends('layouts.app')

@section('page-title', 'Daftar Kegiatan')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Manajemen Kegiatan</h4>
            <p class="text-muted small mb-0">Kelola dan pantau seluruh agenda organisasi Anda.</p>
        </div>
        <a href="{{ route('kegiatan.create') }}" class="btn text-white rounded-3 px-4 shadow-sm" style="background-color: var(--primary-color);">
            <i class="fas fa-plus me-1"></i> Tambah Baru
        </a>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Kegiatan</th>
                            <th>Waktu</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatans as $index => $kegiatan)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $kegiatan->nama_kegiatan }}</div>
                                <small class="text-muted">Creator: {{ $kegiatan->creator->name ?? 'Admin' }}</small>
                            </td>
                            <td>
                                <div class="d-flex flex-column small">
                                    <span class="text-dark"><i class="fas fa-calendar-alt me-2" style="color: var(--primary-color);"></i>{{ $kegiatan->tanggal }}</span>
                                    <span class="text-muted"><i class="fas fa-clock me-2" style="color: var(--secondary-color);"></i>{{ substr($kegiatan->waktu_mulai, 0, 5) }} - {{ substr($kegiatan->waktu_selesai, 0, 5) }}</span>
                                </div>
                            </td>
                            <td><span class="small text-muted"><i class="fas fa-map-marker-alt me-2" style="color: var(--secondary-color);"></i>{{ Str::limit($kegiatan->lokasi, 20) }}</span></td>
                            <td>
                                @php
                                    $statusColor = $kegiatan->status == 'aktif' ? 'var(--primary-color)' : ($kegiatan->status == 'selesai' ? '#6c757d' : '#ffc107');
                                @endphp
                                <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $statusColor }}20; color: {{ $statusColor }};">
                                    {{ ucfirst($kegiatan->status) }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-sm btn-light rounded-circle" style="color: var(--primary-color);">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Tidak ada data kegiatan ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
