@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Invite Anggota</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('absensi.index') }}">Pilih Kegiatan</a></li>
        <li class="breadcrumb-item active">Invite: {{ $kegiatan->nama_kegiatan }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-users me-1"></i>
            Daftar Anggota Aktif
        </div>
        <div class="card-body">
            <form action="{{ route('absensi.store-invite', $kegiatan->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="selectAll()">Pilih Semua</button>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="deselectAll()">Hapus Semua</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="50">Pilih</th>
                                <th>Nama</th>
                                <th>Divisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anggota as $user)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" 
                                    class="form-check-input member-checkbox"
                                    {{ in_array($user->id, $invited_ids) ? 'checked' : '' }}>
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->divisi }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Daftar Invite</button>
                    <a href="{{ route('absensi.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function selectAll() {
    document.querySelectorAll('.member-checkbox').forEach(cb => cb.checked = true);
}
function deselectAll() {
    document.querySelectorAll('.member-checkbox').forEach(cb => cb.checked = false);
}
</script>
@endsection
