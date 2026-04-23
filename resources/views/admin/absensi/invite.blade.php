@extends('layouts.app')

@section('page-title', 'Invite Anggota')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Invite Anggota</h4>
                    <p>Pilih anggota yang akan diikutsertakan pada kegiatan <strong>{{ $kegiatan->nama_kegiatan }}</strong>.</p>
                </div>
            </div>
            <a href="{{ route('absensi.index') }}" class="btn btn-light px-4 fw-bold">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <span><i class="fas fa-users me-2"></i>Daftar Anggota Aktif</span>
        </div>
        <div class="card-body">
            <form action="{{ route('absensi.store-invite', $kegiatan->id) }}" method="POST">
                @csrf
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="selectAll()">Pilih Semua</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="deselectAll()">Hapus Semua</button>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle">
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
                {{ $anggota->links() }}
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Daftar Invite</button>
                    <a href="{{ route('absensi.index') }}" class="btn btn-outline-secondary">Batal</a>
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
