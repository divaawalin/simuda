@extends('layouts.app')

@section('page-title', 'Manajemen Anggota')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-users me-2"></i>Daftar Anggota Organisasi
            </h6>
            <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm rounded-3 shadow-sm">
                <i class="fas fa-plus me-1"></i> Tambah Anggota
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        @if($anggota->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Divisi</th>
                        <th class="d-none d-md-table-cell">Kontak</th>
                        <th>Status</th>
                        <th width="180" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota as $index => $user)
                    <tr>
                        <td><span class="fw-semibold text-muted">{{ $index + 1 }}</span></td>
                        <td>
                            @if($user->foto_profile)
                                <img src="{{ route('storage.profiles', $user->foto_profile) }}" class="rounded-3 shadow-sm" width="45" height="45" style="object-fit: cover; border: 2px solid #f8f9fa;">
                            @else
                                <div class="bg-gradient-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 45px; height: 45px; font-size: 1rem; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <p class="mb-0 fw-bold">{{ $user->name }}</p>
                            <small class="text-muted d-block d-md-inline">{{ $user->email }}</small>
                        </td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                {{ $user->divisi }}
                            </span>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <div class="d-flex flex-column small">
                                <span class="d-flex align-items-center">
                                    <i class="fas fa-phone me-2 text-muted" style="width: 14px;"></i> 
                                    {{ $user->no_telp }}
                                </span>
                                <span class="text-muted d-flex align-items-center mt-1">
                                    <i class="fas fa-map-marker-alt me-2 text-muted" style="width: 14px;"></i> 
                                    {{ Str::limit($user->alamat, 25) }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('anggota.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="border-0 bg-transparent p-0" title="Klik untuk mengubah status">
                                    @if($user->status == 'aktif')
                                        <span class="badge bg-success-subtle px-3 py-2 cursor-pointer fs-13">
                                            <i class="fas fa-check-circle me-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2 cursor-pointer fs-13">
                                            <i class="fas fa-pause-circle me-1"></i> Nonaktif
                                        </span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('anggota.edit', $user->id) }}" class="btn btn-info btn-sm action-btn" title="Edit">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('anggota.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm action-btn confirm-dialog" data-text="Hapus data anggota ini?" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-user-friends fa-3x text-muted mb-3 opacity-20"></i>
                                <p class="text-muted">Belum ada data anggota.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-user-friends fa-3x text-muted mb-3 opacity-20"></i>
            <p class="text-muted mb-0">Belum ada data anggota.</p>
        </div>
        @endif
    </div>
</div>
@endsection
