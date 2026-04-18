@extends('layouts.app')

@section('page-title', 'Manajemen Users Admin')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-user-shield me-2"></i>Daftar Pengguna Admin, Sekretaris, & Ketua
            </h6>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm rounded-3 shadow-sm">
                <i class="fas fa-plus me-1"></i> Tambah User
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Role</th>
                        <th class="d-none d-md-table-cell">Kontak</th>
                        <th width="180" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
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
                                {{ $user->role ?? 'user' }}
                            </span>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <div class="d-flex flex-column small">
                                <span class="d-flex align-items-center">
                                    <i class="fas fa-phone me-2 text-muted" style="width: 14px;"></i> 
                                    {{ $user->no_telp ?? 'N/A' }}
                                </span>
                                <span class="text-muted d-flex align-items-center mt-1">
                                    <i class="fas fa-map-marker-alt me-2 text-muted" style="width: 14px;"></i> 
                                    {{ Str::limit($user->alamat, 25) }}
                                </span>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm action-btn" title="Edit">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm action-btn confirm-dialog" data-text="Hapus user ini?" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-user-shield fa-3x text-muted mb-3 opacity-20"></i>
                                <p class="text-muted mb-0">Belum ada data pengguna admin.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-user-shield fa-3x text-muted mb-3 opacity-20"></i>
            <p class="text-muted mb-0">Belum ada data pengguna admin.</p>
        </div>
        @endif
    </div>
</div>
@endsection
