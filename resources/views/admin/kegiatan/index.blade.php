@extends('layouts.app')

@section('page-title', 'Daftar Kegiatan')

@section('content')
@php
    $totalCount = $kegiatans->total();
@endphp

<div class="dashboard-container">
    {{-- Hero Section --}}
    <div class="hero-premium mb-4">
        <div class="hero-content">
            <div class="hero-logo">
                <div class="hero-logo-icon">
                    <i class="fas fa-calendar-days"></i>
                </div>
            </div>
            <div class="hero-text">
                <div class="hero-greeting">Manajemen Kegiatan</div>
                <h1 class="hero-title">GENERUS JEMBER</h1>
                <p class="hero-subtitle">Kelola ritme kegiatan organisasi, status pelaksanaan, dan detail lokasi dalam satu halaman editorial.</p>
            </div>
            <div class="hero-badges">
                <span class="hero-badge">Live Overview</span>
                <span class="hero-badge">Panel Harian</span>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card-premium h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-wrapper" style="background: rgba(15, 159, 165, 0.1); color: var(--primary-color);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $totalCount }}</div>
                            <div class="stat-label">Total Agenda</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-premium h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-wrapper" style="background: rgba(15, 159, 165, 0.1); color: var(--primary-color);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $aktifCount }}</div>
                            <div class="stat-label">Sedang Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card-premium h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon-wrapper" style="background: rgba(51, 196, 214, 0.12); color: var(--secondary-color);">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $selesaiCount }}</div>
                            <div class="stat-label">Sudah Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="p-4 border-bottom">
        <div class="row align-items-center">
            <div class="col-md-6">
                <form action="{{ route('kegiatan.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control rounded-3" placeholder="Cari nama kegiatan..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary px-4 rounded-3">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-secondary rounded-3">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('kegiatan.create') }}" class="btn btn-primary px-4 rounded-3">
                    <i class="fas fa-plus me-2"></i>Tambah Kegiatan
                </a>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="card stat-card-premium">
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
                            <td class="ps-4 text-muted">{{ ($kegiatans->currentPage() - 1) * $kegiatans->perPage() + $index + 1 }}</td>
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
                                        @csrf
                                        @method('DELETE')
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
        <div class="card-footer bg-white border-0 py-3">
            {{ $kegiatans->links() }}
        </div>
    </div>
</div>
@endsection
