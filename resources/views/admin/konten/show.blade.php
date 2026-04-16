@extends('layouts.app')

@section('title', 'Detail Konten: ' . $konten->nama_konten)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Konten: {{ $konten->nama_konten }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('konten.edit', $konten->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('konten.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    </div>
                </div>

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
                        <div class="row mb-3">
                            <div class="col-md-3"><strong>File:</strong></div>
                            <div class="col-md-9">
                                <a href="{{ Storage::disk('konten')->url($konten->file_path) }}" target="_blank">
                                    {{ $konten->file_path }}
                                </a>
                                {{-- Optionally display image preview if type is 'gambar' --}}
                                @if ($konten->tipe === 'gambar')
                                    <br>
                                    <img src="{{ Storage::disk('konten')->url($konten->file_path) }}" alt="{{ $konten->nama_konten }}" class="img-fluid mt-2" style="max-width: 300px; max-height: 300px;">
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
