@extends('layouts.app')

@section('page-title', 'Export Laporan Absensi')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon">
                    <i class="fas fa-file-export"></i>
                </div>
                <div>
                    <h4 class="fw-bold">Export Laporan Absensi</h4>
                    <p>Download rekap kehadiran dalam format PDF atau Excel.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <span><i class="fas fa-download me-2"></i>Pilih Kegiatan</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('export.pdf') }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Export ke PDF</label>
                            <select name="kegiatan_id" class="form-control" required>
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach($kegiatans as $kegiatan)
                                    <option value="{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }} ({{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d/m/Y') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-file-pdf me-2"></i>Download PDF
                        </button>
                    </form>

                    <hr>

                    <form action="{{ route('export.excel') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Export ke Excel</label>
                            <select name="kegiatan_id" class="form-control" required>
                                <option value="">-- Pilih Kegiatan --</option>
                                @foreach($kegiatans as $kegiatan)
                                    <option value="{{ $kegiatan->id }}">{{ $kegiatan->nama_kegiatan }} ({{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d/m/Y') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-excel me-2"></i>Download Excel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
