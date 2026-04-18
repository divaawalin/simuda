@extends('layouts.app')

@section('page-title', 'Daftar Kegiatan')

@section('content')
<div class="container-fluid px-0">
    @php
        $aktifCount = $kegiatans->where('status', 'aktif')->count();
        $selesaiCount = $kegiatans->where('status', 'selesai')->count();
    @endphp

    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-calendar-days"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Arsitektur Agenda</h4>
                    <p>Kelola ritme kegiatan organisasi, status pelaksanaan, dan detail lokasi dalam satu halaman editorial.</p>
                </div>
            </div>
            <a href="{{ route('kegiatan.create') }}" class="btn btn-light px-4">
                <i class="fas fa-plus me-2"></i>Tambah Baru
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Total Agenda</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $kegiatans->count() }}</div></div></div></div>
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Sedang Aktif</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $aktifCount }}</div></div></div></div>
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Sudah Selesai</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $selesaiCount }}</div></div></div></div>
    </div>

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
