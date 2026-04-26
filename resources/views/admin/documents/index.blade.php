@extends('layouts.app')

@section('page-title', 'Manajemen Dokumen')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-file-archive"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Manajemen Dokumen</h4>
                    <p>Kelola dan unggah dokumen organisasi.</p>
                </div>
            </div>
                <a href="{{ route('admin.documents.create') }}" class="btn btn-primary px-4 fw-bold">
                <i class="fas fa-upload me-2"></i>Unggah Dokumen
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <span><i class="fas fa-list me-2"></i>Daftar Dokumen</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Ukuran</th>
                            <th>Diunggah Oleh</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td>{{ $doc->title }}</td>
                            <td><span class="badge bg-info">{{ $doc->file_type }}</span></td>
                            <td>{{ number_format($doc->file_size / 1024, 2) }} KB</td>
                            <td>{{ $doc->uploadedBy->name }}</td>
                            <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                     <a href="{{ route('admin.documents.show', $doc) }}" class="btn btn-sm btn-success" title="Download">
                                         <i class="fas fa-download"></i> {{ basename($doc->file_path) }}
                                     </a>
                                    <a href="{{ route('admin.documents.edit', $doc) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.documents.destroy', $doc) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus dokumen ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada dokumen.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection
