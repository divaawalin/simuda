@extends('layouts.app')

@section('page-title', 'Daftar Kegiatan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-calendar-alt me-2"></i>Manajemen Kegiatan
            </h6>
            <a href="{{ route('kegiatan.create') }}" class="btn btn-primary btn-sm rounded-3 shadow-sm">
                <i class="fas fa-plus me-1"></i> Tambah Kegiatan
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        @if($kegiatans->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal & Waktu</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th width="180" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatans as $index => $kegiatan)
                    <tr>
                        <td><span class="fw-semibold text-muted">{{ $index + 1 }}</span></td>
                        <td>
                            <p class="mb-0 fw-bold">{{ $kegiatan->nama_kegiatan }}</p>
                            <small class="text-muted d-block d-md-inline">Oleh: {{ $kegiatan->creator->name ?? 'Admin' }}</small>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="d-flex align-items-center">
                                    <i class="fas fa-calendar-day me-2 text-primary" style="width: 14px;"></i> 
                                    {{ $kegiatan->tanggal }}
                                </span>
                                <small class="text-muted d-flex align-items-center mt-1">
                                    <i class="fas fa-clock me-2" style="width: 14px;"></i> 
                                    {{ substr($kegiatan->waktu_mulai, 0, 5) }} - {{ substr($kegiatan->waktu_selesai, 0, 5) }}
                                </small>
                            </div>
                        </td>
                        <td>
                            <small class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt me-2 text-danger" style="width: 14px;"></i> 
                                {{ Str::limit($kegiatan->lokasi, 25) }}
                            </small>
                        </td>
                        <td>
                            @if($kegiatan->status == 'aktif')
                                <span class="badge bg-success-subtle px-3 py-2">
                                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i> Aktif
                                </span>
                            @elseif($kegiatan->status == 'selesai')
                                <span class="badge bg-secondary-subtle px-3 py-2">
                                    <i class="fas fa-check me-1"></i> Selesai
                                </span>
                            @else
                                <span class="badge bg-warning-subtle px-3 py-2">
                                    <i class="fas fa-edit me-1"></i> Draft
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-info btn-sm action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm action-btn confirm-dialog" data-text="Hapus kegiatan ini?" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3 opacity-20"></i>
                                <p class="text-muted">Belum ada data kegiatan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3 opacity-20"></i>
            <p class="text-muted mb-0">Belum ada data kegiatan.</p>
        </div>
        @endif
    </div>
</div>
@endsection
