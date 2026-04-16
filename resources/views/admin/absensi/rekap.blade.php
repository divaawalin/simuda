@extends('layouts.app')

@section('title', 'Rekap Absensi - ' . $kegiatan->nama_kegiatan)

@section('content')
<div class="container">
    <h1 class="mt-4 mb-3">Rekap Absensi untuk Kegiatan: "{{ $kegiatan->nama_kegiatan }}"</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Ringkasan Absensi
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="rekapTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Email</th>
                            @foreach ($sessions as $session)
                                <th>
                                    Sesi {{ $session->started_at->format('d M Y H:i') }} - 
                                    {{ $session->ended_at ? $session->ended_at->format('H:i') : 'Aktif' }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                @foreach ($sessions as $session)
                                    <td>
                                        @php
                                            $attendance = $attendanceData[$user->id]['sessions'][$session->id] ?? null;
                                            $status = $attendance ? $attendance['status'] : 'absent';
                                            $attended_at = $attendance ? \Carbon\Carbon::parse($attendance['attended_at'])->format('H:i:s') : null;
                                        @endphp
                                        @if ($status == 'present')
                                            <span class="badge bg-success">Hadir</span> {{-- @if($attended_at) <small>({{ $attended_at }})</small> @endif --}}
                                        @else
                                            <span class="badge bg-danger">Tidak Hadir</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 2 + count($sessions) }}" class="text-center">Belum ada anggota yang diundang atau sesi yang dimulai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <a href="{{ route('admin.absensi.sesi', $kegiatan->id) }}" class="btn btn-secondary">Kembali ke Kelola Sesi</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any necessary JavaScript here if needed for advanced features
</script>
@endpush
