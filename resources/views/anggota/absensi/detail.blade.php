@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Kegiatan: {{ $kegiatan->name }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-header">
            Sesi Kegiatan
        </div>
        <div class="card-body">
            @if($sesis->isEmpty())
                <p>Belum ada sesi yang dijadwalkan untuk kegiatan ini.</p>
            @else
                @foreach($sesis as $sesi)
                    <div class="border p-3 mb-3 rounded">
                        <h4>Sesi {{ ucfirst($sesi->type) }}</h4>
                        <p>
                            <strong>Status:</strong>
                            @if ($sesi->started_at && now() >= $sesi->started_at)
                                @if ($sesi->ended_at && now() >= $sesi->ended_at)
                                    <span class="badge bg-secondary">Selesai</span>
                                @else
                                    <span class="badge bg-success">Dimulai</span>
                                @endif
                            @elseif ($sesi->started_at)
                                <span class="badge bg-warning text-dark">Akan Datang</span>
                            @else
                                <span class="badge bg-info">Belum Dimulai (Admin belum mengatur waktu)</span>
                            @endif
                        </p>

                        @if ($sesi->started_at && now() >= $sesi->started_at)
                            <p>Waktu Mulai: {{ $sesi->started_at->format('d M Y, H:i') }}</p>

                            {{-- Mandiri Absen Form --}}
                            @if ($sesi->type === 'mulai' || $sesi->type === 'selesai') {{-- Allow attendance for both types if started --}}
                                @php
                                    // Check if attendance is already recorded for this user and session
                                    $attendance = \App\Models\Absensi::where('user_id', Auth::id())
                                                                    ->where('absensi_sesi_id', $sesi->id)
                                                                    ->first();
                                @endphp
                                @if (!$attendance)
                                    <form action="{{ route('anggota.absensi.absen', $kegiatan) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="method" value="mandiri">
                                        <input type="hidden" name="session_id" value="{{ $sesi->id }}">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Absen {{ ucfirst($sesi->type) }} (Mandiri)
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Sudah Absen</span>
                                @endif
                            @endif
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Opsi Lainnya
        </div>
        <div class="card-body">
            {{-- QR Code Button --}}
            <a href="{{ route('anggota.absensi.qr', $kegiatan) }}" class="btn btn-secondary">
                Lihat QR Code Saya
            </a>
            <small class="text-muted ms-2">(Untuk ditunjukkan kepada admin)</small>
        </div>
    </div>
</div>
@endsection
