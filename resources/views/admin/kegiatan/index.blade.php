@extends('layouts.app')

@section('page-title', 'Daftar Kegiatan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary">Manajemen Kegiatan</h6>
        <a href="{{ route('kegiatan.create') }}" class="btn btn-primary btn-sm rounded-3">
            <i class="fas fa-plus me-1"></i> Tambah Kegiatan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal & Waktu</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatans as $index => $kegiatan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <p class="mb-0 fw-bold">{{ $kegiatan->nama_kegiatan }}</p>
                            <small class="text-muted">Oleh: {{ $kegiatan->creator->name ?? 'Admin' }}</small>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span><i class="fas fa-calendar-day me-1 text-primary small"></i> {{ $kegiatan->tanggal }}</span>
                                <small class="text-muted"><i class="fas fa-clock me-1 small"></i> {{ substr($kegiatan->waktu_mulai, 0, 5) }} - {{ substr($kegiatan->waktu_selesai, 0, 5) }}</small>
                            </div>
                        </td>
                        <td>
                            <small><i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $kegiatan->lokasi }}</small>
                        </td>
                        <td>
                            @if($kegiatan->status == 'aktif')
                                <span class="badge bg-success-subtle">Aktif</span>
                            @elseif($kegiatan->status == 'selesai')
                                <span class="badge bg-secondary">Selesai</span>
                            @else
                                <span class="badge bg-warning text-dark">Draft</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-info btn-sm text-white rounded-3 shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-3 shadow-sm confirm-dialog" data-text="Hapus kegiatan ini?" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3 opacity-20"></i>
                            <p class="text-muted">Belum ada data kegiatan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
