@extends('layouts.app')

@section('page-title', 'Manajemen Konten')

@section('content')
<div class="container-fluid px-0">
    @php
        $gambarCount = $kontens->where('tipe', 'gambar')->count();
        $fileCount = $kontens->where('tipe', 'file')->count();
        $linkCount = $kontens->where('tipe', 'link')->count();
    @endphp

    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Content Library</h4>
                    <p>Kelola gambar, dokumen, dan tautan sebagai katalog visual yang siap dibagikan ke anggota.</p>
                </div>
            </div>
            <a href="{{ route('konten.create') }}" class="btn btn-light px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i>Tambah Konten
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Gambar</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $gambarCount }}</div></div></div></div>
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">File</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $fileCount }}</div></div></div></div>
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Link</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $linkCount }}</div></div></div></div>
    </div>

    <div class="row g-4">
        @forelse($kontens as $konten)
        @php
            $typeColor = $konten->tipe === 'gambar' ? 'var(--primary-color)' : ($konten->tipe === 'file' ? '#dc3545' : 'var(--secondary-color)');
        @endphp
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 rounded-4 h-100 overflow-hidden">
                @if($konten->tipe === 'gambar' && $konten->file_path)
                <div style="height:220px;background:#eef6f8;">
                    <img src="{{ route('storage.konten', $konten->file_path) }}" alt="{{ $konten->nama_konten }}" class="w-100 h-100" style="object-fit:cover;">
                </div>
                @endif
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $typeColor }}20; color: {{ $typeColor }};">{{ ucfirst($konten->tipe) }}</span>
                        <small class="text-muted">{{ $konten->created_at->format('d M Y') }}</small>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ $konten->nama_konten }}</h5>
                    <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($konten->deskripsi ?: 'Tidak ada deskripsi.', 110) }}</p>
                    <p class="small text-muted mb-4">
                        <i class="fas {{ $konten->tipe === 'link' ? 'fa-link' : ($konten->tipe === 'file' ? 'fa-file-alt' : 'fa-image') }} me-2" style="color: {{ $typeColor }};"></i>
                        {{ $konten->tipe === 'link' ? \Illuminate\Support\Str::limit($konten->link_url, 42) : \Illuminate\Support\Str::limit($konten->file_path, 42) }}
                    </p>
                    <div class="mt-auto d-flex gap-2">
                        <a href="{{ route('konten.edit', $konten->id) }}" class="btn btn-outline-primary flex-grow-1">
                            <i class="fas fa-pen me-2"></i>Edit
                        </a>
                        <form action="{{ route('konten.destroy', $konten->id) }}" method="POST" class="flex-grow-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-secondary w-100 text-danger">
                                <i class="fas fa-trash-alt me-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 rounded-4"><div class="card-body text-center py-5 text-muted">Belum ada data konten.</div></div>
        </div>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $kontens->links() }}
    </div>
</div>
@endsection
