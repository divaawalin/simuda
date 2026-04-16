@extends('layouts.app')

@section('title', 'Undang Anggota - ' . $kegiatan->nama_kegiatan)

@section('content')
<div class="container">
    <h1 class="mt-4 mb-3">Undang Anggota ke Kegiatan: "{{ $kegiatan->nama_kegiatan }}"</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus me-1"></i>
            Pilih Anggota untuk Diundang
        </div>
        <div class="card-body">
            <form action="{{ route('admin.absensi.storeInvite', $kegiatan->id) }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Anggota yang Tersedia:</label><br>
                    @if($members->isEmpty())
                        <p>Tidak ada anggota lain yang tersedia untuk diundang.</p>
                    @else
                        @foreach ($members as $member)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="member_ids[]" id="member{{ $member->id }}" value="{{ $member->id }}">
                                <label class="form-check-label" for="member{{ $member->id }}">
                                    {{ $member->name }} ({{ $member->email }})
                                </label>
                            </div>
                            <br> {{-- Add a line break for better readability, especially with many members --}}
                        @endforeach
                    @endif
                </div>

                @if(!$members->isEmpty())
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Undang Anggota Terpilih</button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Optional: Link back to session management --}}
    <div class="mb-4">
        <a href="{{ route('admin.absensi.sesi', $kegiatan->id) }}" class="btn btn-secondary">Kembali ke Kelola Sesi</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Optional: Add any necessary JavaScript here
</script>
@endpush
