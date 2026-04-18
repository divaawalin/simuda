@extends('layouts.app')

@section('page-title', 'Manajemen Konten')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Manajemen Konten</h4>
            <p class="text-muted small mb-0">Kelola dokumen, gambar, dan tautan organisasi Anda.</p>
        </div>
        <a href="{{ route('konten.create') }}" class="btn text-white rounded-3 px-4 shadow-sm" style="background-color: var(--primary-color);">
            <i class="fas fa-plus me-1"></i> Tambah Konten
        </a>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Konten</th>
                            <th>Tipe</th>
                            <th>Detail</th>
                            <th>Dibuat Oleh</th>
                            <th>Tanggal</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kontens as $index => $konten)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $konten->nama_konten }}</div>
                                <small class="text-muted">{{ Str::limit($konten->deskripsi, 30) }}</small>
                            </td>
                            <td>
                                @php
                                    $typeColor = $konten->tipe === 'gambar' ? 'var(--primary-color)' : ($konten->tipe === 'file' ? '#dc3545' : 'var(--secondary-color)');
                                @endphp
                                <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $typeColor }}20; color: {{ $typeColor }};">
                                    {{ ucfirst($konten->tipe) }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-muted">
                                    @if($konten->tipe === 'link')
                                        <a href="{{ $konten->link_url }}" target="_blank" class="text-decoration-none" style="color: var(--secondary-color);">
                                            <i class="fas fa-external-link-alt me-1"></i> Tautan
                                        </a>
                                    @else
                                        <i class="fas {{ $konten->tipe === 'file' ? 'fa-file-alt' : 'fa-image' }} me-1"></i> {{ Str::limit($konten->file_path, 20) }}
                                    @endif
                                </div>
                            </td>
                            <td><span class="small fw-semibold text-dark">{{ $konten->creator->name ?? 'Admin' }}</span></td>
                            <td><span class="small text-muted">{{ $konten->created_at->format('d M Y') }}</span></td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('konten.edit', $konten->id) }}" class="btn btn-sm btn-light rounded-circle" style="color: var(--primary-color);">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('konten.destroy', $konten->id) }}" method="POST" class="d-inline">
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
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada data konten.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
