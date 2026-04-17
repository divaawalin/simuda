@extends('layouts.app')

@section('page-title', 'Manajemen Konten')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary">Daftar Konten Organisasi</h6>
        <a href="{{ route('konten.create') }}" class="btn btn-primary btn-sm rounded-3 shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Konten
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Konten</th>
                        <th>Tipe</th>
                        <th>File/Link</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kontens as $index => $konten)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <p class="mb-0 fw-bold">{{ $konten->nama_konten }}</p>
                            <small class="text-muted">{{ Str::limit($konten->deskripsi, 30) }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $konten->tipe === 'gambar' ? 'bg-success-subtle' : ($konten->tipe === 'file' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle') }} px-3 rounded-pill">{{ ucfirst($konten->tipe) }}</span>
                        </td>
                        <td>
                            @if($konten->tipe === 'link')
                                <a href="{{ $konten->link_url }}" target="_blank" class="text-primary text-decoration-underline small">
                                    <i class="fas fa-link me-1"></i> {{ Str::limit($konten->link_url, 30) }}
                                </a>
                            @else
                                <span class="text-muted small"><i class="fas {{ $konten->tipe === 'file' ? 'fa-file-alt' : 'fa-image' }} me-1"></i> {{ Str::limit($konten->file_path, 30) }}</span>
                            @endif
                        </td>
                        <td>
                            <p class="mb-0 fw-bold">{{ $konten->creator->name ?? 'Admin' }}</p>
                        </td>
                        <td>
                            <small class="text-muted">{{ $konten->created_at->format('d M Y H:i') }}</small>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('konten.edit', $konten->id) }}" class="btn btn-info btn-sm text-white rounded-3 shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('konten.destroy', $konten->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-3 shadow-sm confirm-dialog" data-text="Hapus konten ini?" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-20"></i>
                            <p class="text-muted">Belum ada data konten.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
