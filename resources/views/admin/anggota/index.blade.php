@extends('layouts.app')

@section('page-title', 'Manajemen Anggota')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 fw-bold text-primary">Daftar Anggota Organisasi</h6>
        <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm rounded-3 shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Anggota
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Divisi</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th width="180" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($user->foto_profile)
                                <img src="{{ route('storage.profiles', $user->foto_profile) }}" class="rounded-circle shadow-sm" width="40" height="40" style="object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 0.8rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <p class="mb-0 fw-bold">{{ $user->name }}</p>
                            <small class="text-muted">{{ $user->email }}</small>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle rounded-pill">{{ $user->divisi }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column small">
                                <span><i class="fas fa-phone me-1 text-muted"></i> {{ $user->no_telp }}</span>
                                <span class="text-muted"><i class="fas fa-map-marker-alt me-1 text-muted"></i> {{ Str::limit($user->alamat, 20) }}</span>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('anggota.toggle-status', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="border-0 bg-transparent p-0" title="Klik untuk mengubah status">
                                    @if($user->status == 'aktif')
                                        <span class="badge bg-success-subtle px-3 py-2 cursor-pointer">Aktif <i class="fas fa-sync-alt ms-1 small"></i></span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2 cursor-pointer">Nonaktif <i class="fas fa-sync-alt ms-1 small"></i></span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('anggota.edit', $user->id) }}" class="btn btn-info btn-sm text-white rounded-3 shadow-sm" title="Edit">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('anggota.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-3 shadow-sm confirm-dialog" data-text="Hapus data anggota ini?" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-user-friends fa-3x text-muted mb-3 opacity-20"></i>
                            <p class="text-muted">Belum ada data anggota.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
