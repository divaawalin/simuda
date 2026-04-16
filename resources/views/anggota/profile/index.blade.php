@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Profil Anggota</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">Informasi Profil</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if ($user->foto_profile)
                        {{-- Assuming foto_profile stores the path relative to the 'profiles' disk, specifically in 'uploads' subdirectory --}}
                        <img src="{{ asset('storage/uploads/' . $user->foto_profile) }}" alt="Foto Profil" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        {{-- Placeholder for default avatar --}}
                        <img src="{{ asset('path/to/default/avatar.png') }}" alt="Foto Profil Default" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif
                </div>
                <div class="col-md-8">
                    <p><strong>Nama:</strong> {{ $user->name }}</p>
                    <p><strong>Divisi:</strong> {{ $user->divisi ?? 'Belum diatur' }}</p>
                    <p><strong>Nomor Telepon:</strong> {{ $user->no_telp ?? 'Belum diatur' }}</p>
                    <p><strong>Alamat:</strong> {{ $user->alamat ?? 'Belum diatur' }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('anggota.profile.edit') }}" class="btn btn-primary">Edit Profil</a>
        </div>
    </div>
</div>
@endsection
