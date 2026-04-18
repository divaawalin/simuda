@extends('layouts.app')

@section('page-title', 'Manajemen Anggota')

@section('content')
<div class="container-fluid px-0">
    @php
        $aktifCount = $anggota->where('status', 'aktif')->count();
        $divisiCount = $anggota->pluck('divisi')->filter()->unique()->count();
    @endphp

    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-users-gear"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Directory Anggota</h4>
                    <p>Kelola status, divisi, kontak, dan identitas anggota dengan tampilan seperti direktori organisasi modern.</p>
                </div>
            </div>
            <a href="{{ route('anggota.create') }}" class="btn btn-light px-4 shadow-sm">
                <i class="fas fa-user-plus me-2"></i>Tambah Anggota
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Total Anggota</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $anggota->count() }}</div></div></div></div>
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Status Aktif</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $aktifCount }}</div></div></div></div>
        <div class="col-md-4"><div class="card border-0 rounded-4"><div class="card-body p-4"><small class="text-uppercase fw-bold text-muted d-block mb-2">Jumlah Divisi</small><div class="display-6" style="font-size:2.2rem;font-weight:800;">{{ $divisiCount }}</div></div></div></div>
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
                            <th>Divisi</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $index => $user)
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
                                    {{ $user->divisi }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-muted"><i class="fas fa-phone me-1" style="color: var(--secondary-color);"></i>{{ $user->no_telp }}</div>
                            </td>
                            <td>
                                <form action="{{ route('anggota.toggle-status', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent p-0">
                                        @php
                                            $statusColor = $user->status == 'aktif' ? 'var(--primary-color)' : '#dc3545';
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: {{ $statusColor }}20; color: {{ $statusColor }};">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('anggota.edit', $user->id) }}" class="btn btn-sm btn-light rounded-circle" style="color: var(--primary-color);">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('anggota.destroy', $user->id) }}" method="POST" class="d-inline">
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
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada data anggota.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
