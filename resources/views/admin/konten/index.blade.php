@extends('layouts.app')

@section('title', 'Daftar Konten')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Konten</h3>
                    <div class="card-tools">
                        <a href="{{ route('konten.create') }}" class="btn btn-primary btn-sm">Tambah Konten Baru</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($kontens->isEmpty())
                        <p>Belum ada konten yang ditambahkan.</p>
                    @else
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Konten</th>
                                    <th>Deskripsi</th>
                                    <th>Tipe</th>
                                    <th>File/Link</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kontens as $konten)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $konten->nama_konten }}</td>
                                        <td>{{ Str::limit($konten->deskripsi, 50) }}</td>
                                        <td>{{ ucfirst($konten->tipe) }}</td>
                                        <td>
                                            @if ($konten->tipe === 'link')
                                                <a href="{{ $konten->link_url }}" target="_blank">{{ $konten->link_url }}</a>
                                            @elseif ($konten->file_path)
                                                <a href="{{ Storage::disk('konten')->url($konten->file_path) }}" target="_blank">
                                                    Lihat File
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $konten->creator->name ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('konten.show', $konten->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                            <a href="{{ route('konten.edit', $konten->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('konten.destroy', $konten->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Anda yakin ingin menghapus konten ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $kontens->links() }} {{-- For pagination --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
