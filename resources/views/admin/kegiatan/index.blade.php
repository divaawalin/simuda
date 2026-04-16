@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Daftar Kegiatan</h2>
    <a href="{{ route('kegiatan.create') }}" class="btn btn-primary">Tambah Kegiatan</a>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Dibuat Oleh</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($kegiatans as $index => $kegiatan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kegiatan->nama_kegiatan }}</td>
                <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}</td>
                <td>{{ substr($kegiatan->waktu_mulai, 0, 5) }} - {{ substr($kegiatan->waktu_selesai, 0, 5) }}</td>
                <td>{{ $kegiatan->lokasi }}</td>
                <td>
                    @if($kegiatan->status == 'draft')
                        <span class="badge badge-secondary">Draft</span>
                    @elseif($kegiatan->status == 'aktif')
                        <span class="badge badge-info">Aktif</span>
                    @else
                        <span class="badge badge-success">Selesai</span>
                    @endif
                </td>
                <td>{{ $kegiatan->creator->name }}</td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data kegiatan.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
