@extends('layouts.app')

@section('page-title', 'Detail Konten')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon"><i class="fas fa-folder-open"></i></div>
                <div>
                    <h4 class="fw-bold">{{ $konten->nama_konten }}</h4>
                    <p>Ringkasan lengkap metadata, tipe, dan sumber konten.</p>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('konten.edit', $konten->id) }}" class="btn btn-light btn-sm px-4">Edit</a>
                <a href="{{ route('konten.index') }}" class="btn btn-light btn-sm px-4">Kembali</a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Nama Konten:</strong></div>
                        <div class="col-md-9">{{ $konten->nama_konten }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Deskripsi:</strong></div>
                        <div class="col-md-9">{{ $konten->deskripsi ?? '-' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Tipe:</strong></div>
                        <div class="col-md-9">{{ ucfirst($konten->tipe) }}</div>
                    </div>

                    @if ($konten->tipe === 'link')
                        <div class="row mb-3">
                            <div class="col-md-3"><strong>URL:</strong></div>
                            <div class="col-md-9"><a href="{{ $konten->link_url }}" target="_blank">{{ $konten->link_url }}</a></div>
                        </div>
                    @elseif ($konten->file_path)
                        @php($fileUrl = route('storage.konten', $konten->file_path))
                        <div class="row mb-3">
                            <div class="col-md-3"><strong>File:</strong></div>
                            <div class="col-md-9">
                                <a href="{{ $fileUrl }}" target="_blank">
                                    {{ $konten->file_path }}
                                </a>
                                @if ($konten->tipe === 'gambar')
                                    <br>
                                    <img src="{{ $fileUrl }}" alt="{{ $konten->nama_konten }}" class="img-fluid mt-2 rounded-4" style="max-width: 300px; max-height: 300px;">
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Dibuat Oleh:</strong></div>
                        <div class="col-md-9">{{ $konten->creator->name ?? 'N/A' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Tanggal Dibuat:</strong></div>
                        <div class="col-md-9">{{ $konten->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
