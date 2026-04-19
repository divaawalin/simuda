@extends('layouts.app')

@section('page-title', 'Manajemen Users Admin')

@section('content')
<div class="container-fluid px-0">
    @php
        $adminOnly = $users->where('role', 'admin')->count();
        $sekretarisOnly = $users->where('role', 'sekretaris')->count();
        $ketuaOnly = $users->where('role', 'ketua')->count();
    @endphp

    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Access Control Room</h4>
                    <p>Kelola akun dengan hak istimewa dan struktur peran inti organisasi secara lebih terkurasi.</p>
                </div>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-light px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i>Tambah Admin
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Admin</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $adminOnly }}</div></div></div></div>
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Sekretaris</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $sekretarisOnly }}</div></div></div></div>
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Ketua</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $ketuaOnly }}</div></div></div></div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Profil</th>
                            <th>Informasi</th>
                            <th>Role</th>
                            <th>Kontak</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td>
                                @if($user->foto_profile)
                                    <img src="{{ route('storage.profiles', $user->foto_profile) }}" class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2" style="background-color: var(--primary-color)20; color: var(--primary-color);">
                                    {{ ucfirst($user->role ?? 'user') }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-muted"><i class="fas fa-phone me-1" style="color: var(--secondary-color);"></i>{{ $user->no_telp ?? '-' }}</div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-light rounded-circle" style="color: var(--primary-color);">
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data admin.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
