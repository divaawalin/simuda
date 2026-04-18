@extends('layouts.app')

@section('page-title', 'Konten')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm p-4 mb-4 rounded-4" style="background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));">
        <div class="d-flex align-items-center">
            <div class="text-white p-3 rounded-4 me-4" style="background-color: rgba(255, 255, 255, 0.15);">
                <i class="fas fa-folder-open fa-2x"></i>
            </div>
            <div>
                <h4 class="fw-bold text-white mb-1">Konten Admin</h4>
                <p class="text-white-50 small mb-0">Lihat, unduh, atau buka konten yang dibagikan admin.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($konten as $item)
        @php
            $typeColor = $item->tipe === 'gambar' ? 'var(--primary-color)' : ($item->tipe === 'file' ? '#dc3545' : 'var(--secondary-color)');
            $downloadUrl = $item->file_path ? route('storage.konten', $item->file_path) : null;
        @endphp
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                @if($item->tipe === 'gambar' && $downloadUrl)
                <div style="height: 220px; background: #f4f7fb;">
                    <img src="{{ $downloadUrl }}" alt="{{ $item->nama_konten }}" class="w-100 h-100" style="object-fit: cover;">
                </div>
                @endif
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                        <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $typeColor }}20; color: {{ $typeColor }};">
                            {{ ucfirst($item->tipe) }}
                        </span>
                        <small class="text-muted text-end">{{ $item->created_at?->format('d M Y') }}</small>
                    </div>

                    <h6 class="fw-bold text-dark mb-2">{{ $item->nama_konten }}</h6>
                    <p class="text-muted small mb-3">{{ $item->deskripsi ?: 'Tidak ada deskripsi untuk konten ini.' }}</p>

                    @if($item->tipe !== 'link' && $item->file_path)
                    <p class="text-muted small mb-4">
                        <i class="fas {{ $item->tipe === 'gambar' ? 'fa-image' : 'fa-file-alt' }} me-1" style="color: {{ $typeColor }};"></i>
                        {{ \Illuminate\Support\Str::limit($item->file_path, 40) }}
                    </p>
                    @elseif($item->tipe === 'link' && $item->link_url)
                    <p class="text-muted small mb-4">
                        <i class="fas fa-link me-1" style="color: {{ $typeColor }};"></i>
                        {{ \Illuminate\Support\Str::limit($item->link_url, 45) }}
                    </p>
                    @endif

                    <div class="mt-auto d-grid">
                        @if($item->tipe === 'link' && $item->link_url)
                        <a href="{{ $item->link_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary rounded-3 fw-bold">
                            <i class="fas fa-external-link-alt me-2"></i>Lihat
                        </a>
                        @elseif($downloadUrl)
                        <a href="{{ $downloadUrl }}" download class="btn text-white rounded-3 fw-bold" style="background-color: var(--primary-color);">
                            <i class="fas fa-download me-2"></i>Download
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center py-5 text-muted">
                    Belum ada konten yang ditambahkan admin.
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
