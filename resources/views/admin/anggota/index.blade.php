@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Manajemen Anggota</h2>
    <a href="{{ route('anggota.create') }}" class="btn btn-primary">Tambah Anggota</a>
</div>

<table>
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Email</th>
            <th>No. Telp</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($anggota as $item)
        <tr>
            <td>
                @if($item->foto_profile)
                    <img src="{{ route('storage.profiles', $item->foto_profile) }}" alt="{{ $item->name }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                @else
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #ddd; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #777;">
                        {{ substr($item->name, 0, 1) }}
                    </div>
                @endif
            </td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->divisi }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->no_telp }}</td>
            <td>
                <span class="badge {{ $item->status === 'aktif' ? 'badge-success' : 'badge-secondary' }}">
                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                </span>
            </td>
            <td>
                <div style="display: flex; gap: 5px;">
                    <form action="{{ route('anggota.toggle-status', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn {{ $item->status === 'aktif' ? 'btn-warning' : 'btn-success' }} btn-sm">
                            {{ $item->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    <a href="{{ route('anggota.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('anggota.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align: center;">Tidak ada data anggota.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
