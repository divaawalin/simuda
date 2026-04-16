@extends('layouts.app')

@section('title', 'Manajemen Absensi - ' . $kegiatan->nama_kegiatan)

@section('content')
<div class="container">
    <h1 class="mt-4 mb-3">Manajemen Absensi untuk Kegiatan: "{{ $kegiatan->nama_kegiatan }}"</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Pilih Sesi Absensi
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="sessionsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sesi Mulai</th>
                            <th>Sesi Berakhir</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sessions as $session)
                            <tr>
                                <td>{{ $session->started_at ? $session->started_at->format('Y-m-d H:i:s') : 'Belum Mulai' }}</td>
                                <td>{{ $session->ended_at ? $session->ended_at->format('Y-m-d H:i:s') : 'Aktif' }}</td>
                                <td>{{ ucfirst($session->method) }}</td>
                                <td>
                                    @if($session->started_at && !$session->ended_at)
                                        <span class="badge bg-warning text-dark">Aktif</span>
                                    @elseif($session->ended_at)
                                        <span class="badge bg-secondary">Selesai</span>
                                    @else
                                        <span class="badge bg-info">Belum Dimulai</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$session->started_at)
                                        {{-- Form to start session --}}
                                        <form action="{{ route('admin.absensi.sesiMulai', $kegiatan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="method" value="{{ $session->method }}">
                                            <input type="hidden" name="start_date" value="{{ now()->format('Y-m-d') }}">
                                            <input type="hidden" name="start_time" value="{{ now()->format('H:i') }}">
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Mulai sesi absensi ini?')">Mulai</button>
                                        </form>
                                    @endif
                                    @if($session->started_at && !$session->ended_at)
                                        {{-- Form to end session --}}
                                        <form action="{{ route('admin.absensi.sesiAkhiri', $kegiatan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Akhiri sesi absensi ini?')">Akhiri</button>
                                        </form>
                                        {{-- Link to QR scanner if method is qr_code --}}
                                        @if($session->method === 'qr_code')
                                            <a href="{{ route('admin.absensi.qr', $kegiatan->id) }}" class="btn btn-primary btn-sm">Lihat QR Code</a>
                                        @endif
                                    @endif
                                    <a href="{{ route('admin.absensi.rekap', $kegiatan->id) }}" class="btn btn-info btn-sm">Rekap</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada sesi absensi untuk kegiatan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Form to start a new session --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Mulai Sesi Baru
        </div>
        <div class="card-body">
            <form action="{{ route('admin.absensi.sesiMulai', $kegiatan->id) }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="method">Metode Absensi</label>
                        <select name="method" id="method" class="form-select" required>
                            <option value="mandiri">Mandiri</option>
                            <option value="qr_code">QR Code</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="start_date">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="start_time">Waktu Mulai</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" value="{{ now()->format('H:i') }}" required>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Mulai Sesi Baru</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Link to invite members --}}
    <div class="mb-4">
        <a href="{{ route('admin.absensi.invite', $kegiatan->id) }}" class="btn btn-success">Undang Anggota</a>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Optional: Add any necessary JavaScript for date/time pickers or dynamic behavior
</script>
@endpush
