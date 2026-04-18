@extends('layouts.app')

@section('page-title', 'Manajemen Konten')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-layer-group me-2"></i>Daftar Konten Organisasi
            </h6>
            <a href="{{ route('konten.create') }}" class="btn btn-primary btn-sm rounded-3 shadow-sm">
                <i class="fas fa-plus me-1"></i> Tambah Konten
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        @if($kontens->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Nama Konten</th>
                        <th>Tipe</th>
                        <th class="d-none d-md-table-cell">File/Link</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal</th>
                        <th width="180" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kontens as $index => $konten)
                    <tr>
                        <td><span class="fw-semibold text-muted">{{ $index + 1 }}</span></td>
                        <td>
                            <p class="mb-0 fw-bold">{{ $konten->nama_konten }}</p>
                            <small class="text-muted">{{ Str::limit($konten->deskripsi, 30) }}</small>
                        </td>
                        <td>
                            @if($konten->tipe === 'gambar')
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                    <i class="fas fa-image me-1"></i> Gambar
                                </span>
                            @elseif($konten->tipe === 'file')
                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                    <i class="fas fa-file-alt me-1"></i> File
                                </span>
                            @else
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                    <i class="fas fa-link me-1"></i> Link
                                </span>
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell">
                            @if($konten->tipe === 'link')
                                <a href="{{ $konten->link_url }}" target="_blank" class="text-primary text-decoration-underline small">
                                    <i class="fas fa-external-link-alt me-1"></i> {{ Str::limit($konten->link_url, 30) }}
                                </a>
                            @else
                                <span class="text-muted small">
                                    <i class="fas {{ $konten->tipe === 'file' ? 'fa-file-alt' : 'fa-image' }} me-1"></i> 
                                    {{ Str::limit($konten->file_path, 30) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <p class="mb-0 fw-bold small">{{ $konten->creator->name ?? 'Admin' }}</p>
                        </td>
                        <td>
                            <small class="text-muted">{{ $konten->created_at->format('d M Y') }}</small>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('konten.edit', $konten->id) }}" class="btn btn-info btn-sm action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('konten.destroy', $konten->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm action-btn confirm-dialog" data-text="Hapus konten ini?" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-20"></i>
                                <p class="text-muted">Belum ada data konten.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-20"></i>
            <p class="text-muted mb-0">Belum ada data konten.</p>
        </div>
        @endif
    </div>
</div>
@endsection
