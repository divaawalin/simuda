@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Konten Terbaru</h1>
    <div class="row">
        @forelse ($konten as $item)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">{{ $item->title }}</div>
                    <div class="card-body">
                        @if ($item->type === 'image')
                            {{-- Assuming 'url' stores the path to the image --}}
                            <img src="{{ asset('storage/' . $item->url) }}" alt="{{ $item->title }}" class="img-fluid" style="max-height: 200px; object-fit: cover;">
                        @elseif ($item->type === 'file')
                            {{-- Assuming 'url' stores the path to the file and can be directly linked for download --}}
                            <p>File: {{ basename($item->url) }}</p>
                            <a href="{{ asset('storage/' . $item->url) }}" class="btn btn-primary btn-sm" download>Unduh File</a>
                        @elseif ($item->type === 'link')
                            <a href="{{ $item->url }}" target="_blank">{{ $item->title }}</a>
                        @else
                            {{-- Fallback for unknown types or if 'url' is not applicable --}}
                            <p>Tipe konten tidak dikenali atau tidak ada konten visual.</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p>Belum ada konten yang tersedia.</p>
        @endempty
    </div>
</div>
@endsection
