@extends('layouts.app')

@section('page-title', 'Manajemen Anggota')

@section('content')
@push('styles')
<style>
    /* Ensure modal and backdrop have proper stacking order */
    #importModal.modal {
        z-index: 1060 !important;
        pointer-events: auto !important;
    }
    .modal-backdrop {
        z-index: 1040 !important;
    }
</style>
@endpush
@php
    $aktifCount = $anggota->where('status', 'aktif')->count();
    $divisiCount = $anggota->pluck('divisi')->filter()->unique()->count();
@endphp

<div class="dashboard-container">
    {{-- Page Header --}}
    <div class="hero-premium mb-4">
        <div class="hero-content">
            <div class="hero-logo">
                <div class="hero-logo-icon">
                    <i class="fas fa-users-gear"></i>
                </div>
            </div>
            <div class="hero-text">
                <div class="hero-greeting">Manajemen Anggota</div>
                <h1 class="hero-title">GENERUS JEMBER</h1>
                <p class="hero-subtitle">Kelola status, divisi, kontak, dan identitas anggota dengan tampilan seperti direktori organisasi modern.</p>
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
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $anggota->total() }}</div>
                            <div class="stat-label">Total Anggota</div>
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
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $aktifCount }}</div>
                            <div class="stat-label">Status Aktif</div>
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
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $divisiCount }}</div>
                            <div class="stat-label">Jumlah Divisi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gender Statistics Row --}}
    <div class="row g-3 mb-4">
        {{-- Male Card --}}
        <div class="col-md-6">
            <div class="card stat-card-premium h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="stat-icon-wrapper" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; width: 40px; height: 40px; font-size: 1rem;">
                                <i class="fas fa-mars"></i>
                            </div>
                            <div>
                                <div class="stat-label text-muted small mb-1">Laki-laki</div>
                                <div class="stat-value mb-0" style="font-size: 1.5rem;">{{ $maleCount }}</div>
                                <small class="text-muted">{{ $malePercent }}% dari total</small>
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 80px; height: 80px;">
                            <canvas id="maleChart" style="max-height: 100%; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Female Card --}}
        <div class="col-md-6">
            <div class="card stat-card-premium h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-wrapper" style="background: rgba(236, 72, 153, 0.1); color: #ec4899; width: 56px; height: 56px; font-size: 1.5rem;">
                                <i class="fas fa-venus"></i>
                            </div>
                            <div>
                                <div class="stat-label text-muted small">Perempuan</div>
                                <div class="stat-value mb-0">{{ $femaleCount }}</div>
                                <small class="text-muted">{{ $femalePercent }}% dari total</small>
                            </div>
                        </div>
                        <div class="flex-shrink-0" style="width: 120px; height: 120px;">
                            <canvas id="femaleChart" style="max-height: 100%; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Card with Table --}}
    <div class="card stat-card-premium">
        <div class="card-body p-0">
            {{-- Toolbar --}}
            <div class="p-4 border-bottom">
                <div class="row align-items-center">
<div class="col-md-5">
                         <form action="{{ route('admin.anggota.index') }}" method="GET" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control rounded-3" placeholder="Cari nama, email, divisi, desa, kelompok, jenis kelamin..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary px-4 rounded-3">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request('search'))
                                 <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary rounded-3">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </form>
                    </div>
                    <div class="col-md-7 text-end">
                         <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary px-4 rounded-3 me-2">
                            <i class="fas fa-user-plus me-2"></i>Tambah Anggota
                        </a>
                        <button type="button" class="btn btn-outline-primary px-4 rounded-3" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="fas fa-file-excel me-2"></i>Import Excel
                        </button>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 text-nowrap text-uppercase fw-bold py-3">#</th>
                            <th class="text-nowrap text-uppercase fw-bold py-3">PROFIL</th>
                            <th class="text-uppercase fw-bold py-3">INFORMASI</th>
                            <th class="text-nowrap text-uppercase fw-bold py-3">DIVISI</th>
                            <th class="text-uppercase fw-bold py-3" style="min-width: 150px;">DESA</th>
                            <th class="text-uppercase fw-bold py-3" style="min-width: 150px;">KELOMPOK</th>
                            <th class="text-center pe-4 text-nowrap text-uppercase fw-bold py-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $index => $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ ($anggota->currentPage() - 1) * $anggota->perPage() + $index + 1 }}</td>
                            <td>
                                @if($user->foto_profile)
                                    <img src="{{ route('storage.profiles', $user->foto_profile) }}" class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                                <div class="small text-muted mt-1"><i class="fas fa-phone me-1" style="color: var(--secondary-color);"></i>{{ $user->no_telp }}</div>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2" style="background-color: var(--primary-color)20; color: var(--primary-color); white-space: nowrap;">
                                    {{ $user->divisi }}
                                </span>
                            </td>
                            <td style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $user->desa ?? '-' }}">
                                {{ $user->desa ?? '-' }}
                            </td>
                            <td style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $user->kelompok ?? '-' }}">
                                {{ $user->kelompok ?? '-' }}
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                     <a href="{{ route('admin.anggota.edit', $user->id) }}" class="btn btn-sm btn-light rounded-circle" style="color: var(--primary-color);">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                     <form action="{{ route('admin.anggota.destroy', $user->id) }}" method="POST" class="d-inline">
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
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada data anggota.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                {{ $anggota->links() }}
            </div>
        </div>
    </div>
</div>

@push('modals')
<div class="modal fade" id="importModal" tabindex="-1" style="z-index:1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-file-excel me-2" style="color: var(--primary-color);"></i>Import Anggota Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
             <form action="{{ route('admin.anggota.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Pilih File Excel</label>
                        <input type="file" name="file" class="form-control rounded-3" accept=".xlsx,.xls" required>
                        <div class="form-text mt-1">Format: .xlsx atau .xls (Maks. 2MB)</div>
                    </div>
                    <div class="mb-3">
                         <a href="{{ route('admin.anggota.template') }}" class="btn btn-sm btn-outline-secondary rounded-3">
                            <i class="fas fa-download me-1"></i>Download Template
                        </a>
                    </div>
                    <div class="alert alert-info rounded-3">
                        <small><strong>Petunjuk:</strong> File harus memiliki kolom: nama, email, no_hp, divisi, status (aktif/tidak_aktif).</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">
                        <i class="fas fa-upload me-1"></i>Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Import modal script loaded');

        // Male mini donut
        const ctxMale = document.getElementById('maleChart');
        if (ctxMale) {
            new Chart(ctxMale, {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Lainnya'],
                    datasets: [{
                        data: [{{ $maleCount ?? 0 }}, {{ $femaleCount ?? 0 }}],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.85)',
                            'rgba(0, 0, 0, 0.05)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'transparent'
                        ],
                        borderWidth: 0,
                        hoverOffset: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });
        }

        // Female mini donut
        const ctxFemale = document.getElementById('femaleChart');
        if (ctxFemale) {
            new Chart(ctxFemale, {
                type: 'doughnut',
                data: {
                    labels: ['Perempuan', 'Lainnya'],
                    datasets: [{
                        data: [{{ $femaleCount ?? 0 }}, {{ $maleCount ?? 0 }}],
                        backgroundColor: [
                            'rgba(236, 72, 153, 0.85)',
                            'rgba(0, 0, 0, 0.05)'
                        ],
                        borderColor: [
                            'rgba(236, 72, 153, 1)',
                            'transparent'
                        ],
                        borderWidth: 0,
                        hoverOffset: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection
