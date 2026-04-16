@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Kegiatan Undangan Anda</h1>

    @if($kegiatans->isEmpty())
        <p>Anda belum diundang ke kegiatan apapun.</p>
    @else
        <div class="list-group">
            @foreach($kegiatans as $kegiatan)
                <a href="{{ route('anggota.absensi.detail', $kegiatan) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $kegiatan->name }}</h5>
                        <small>{{ $kegiatan->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1">Deskripsi singkat kegiatan...</p> {{-- Placeholder for description --}}
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
