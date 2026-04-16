@extends('layouts.app')

@section('title', 'Manajemen Absensi - Daftar Kegiatan')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-3">Manajemen Absensi</h1>
    <p class="mb-4">Pilih kegiatan untuk mengelola absensi.</p>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Daftar Kegiatan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="kegiatanTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kegiatans as $kegiatan)
                            <tr>
                                <td>{{ $kegiatan->nama_kegiatan }}</td>
                                <td>{{ $kegiatan->tanggal->format('Y-m-d') }}</td>
                                <td>{{ $kegiatan->lokasi }}</td>
                                <td>
                                    <a href="{{ route('admin.absensi.invite', $kegiatan->id) }}" class="btn btn-sm btn-primary me-2">Undang Anggota</a>
                                    <a href="{{ route('admin.absensi.sesi', $kegiatan->id) }}" class="btn btn-sm btn-success me-2">Kelola Sesi</a>
                                    <a href="{{ route('admin.absensi.rekap', $kegiatan->id) }}" class="btn btn-sm btn-info">Lihat Rekap</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada kegiatan yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Add any necessary scripts here, e.g., for DataTables if you implement it --}}
@endpush
