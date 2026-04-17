@extends('layouts.app')

@section('page-title', 'Kelola Sesi Absensi')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm p-4 bg-white">
            <div class="d-flex align-items-center">
                <div class="bg-primary-subtle p-3 rounded-4 text-primary me-4">
                    <i class="fas fa-calendar-check fa-2x"></i>
                </div>
                <div>
                    <h4 class="fw-800 mb-1 text-primary">{{ $kegiatan->nama_kegiatan }}</h4>
                    <p class="mb-0 text-muted"><i class="fas fa-map-marker-alt me-1"></i> {{ $kegiatan->lokasi }} | <i class="fas fa-calendar-day me-1 ms-2"></i> {{ $kegiatan->tanggal }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Sesi Mulai -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary"><i class="fas fa-sign-in-alt me-2"></i>Sesi Mulai</h6>
            </div>
            <div class="card-body">
                @if($sesi_mulai)
                    <div class="text-center mb-4 py-3">
                        <div class="mb-3">
                            @if($sesi_mulai->status_sesi == 'berlangsung')
                                <div class="spinner-grow text-success" role="status" style="width: 3rem; height: 3rem;"></div>
                                <h5 class="mt-3 fw-bold text-success">Sesi Berlangsung</h5>
                            @else
                                <i class="fas fa-check-circle fa-4x text-muted mb-3"></i>
                                <h5 class="fw-bold text-muted">Sesi Selesai</h5>
                            @endif
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-4 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Metode</span>
                            <span class="badge bg-primary-subtle px-3">{{ ucfirst($sesi_mulai->metode) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Waktu Mulai</span>
                            <span class="fw-bold small">{{ $sesi_mulai->dimulai_at->format('H:i:s d M Y') }}</span>
                        </div>
                        @if($sesi_mulai->status_sesi == 'selesai')
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Waktu Selesai</span>
                            <span class="fw-bold small">{{ $sesi_mulai->diselesaikan_at->format('H:i:s d M Y') }}</span>
                        </div>
                        @endif
                    </div>

                    @if($sesi_mulai->status_sesi == 'berlangsung')
                        <div class="d-grid gap-2">
                            <form action="{{ route('absensi.sesi-akhiri', $kegiatan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipe_sesi" value="mulai">
                                <button type="submit" class="btn btn-danger w-100 rounded-3 shadow-sm confirm-dialog" data-text="Akhiri sesi mulai?" title="Akhiri Sesi">
                                    <i class="fas fa-stop-circle me-1"></i> Akhiri Sesi
                                </button>
                            </form>
                            @if($sesi_mulai->metode == 'qr_code')
                                <a href="{{ route('absensi.qr', $kegiatan->id) }}" class="btn btn-primary rounded-3 shadow-sm">
                                    <i class="fas fa-qrcode me-1"></i> Buka QR Scanner
                                </a>
                            @endif
                        </div>
                    @endif
                @else
                    <div class="text-center py-4 mb-3">
                        <i class="fas fa-door-open fa-4x text-muted opacity-10 mb-3"></i>
                        <h6 class="text-muted">Sesi mulai belum dibuka.</h6>
                    </div>
                    <form action="{{ route('absensi.sesi-mulai', $kegiatan->id) }}" method="POST" id="formMulai">
                        @csrf
                        <input type="hidden" name="tipe_sesi" value="mulai">
                        <input type="hidden" name="metode" id="metode_mulai" value="">
                        <p class="text-muted small fw-bold mb-3">PILIH METODE ABSENSI</p>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="metode_mulai_qr" class="w-100 p-3 rounded-4 border-2 cursor-pointer text-center hover-overlay" style="border: 2px solid #0d6efd; cursor: pointer;">
                                    <input type="radio" name="metode_radio" id="metode_mulai_qr" value="qr_code" class="d-none">
                                    <i class="fas fa-qrcode fa-2x text-primary d-block mb-2"></i>
                                    <span class="fw-bold text-primary">QR Code</span>
                                    <p class="small text-muted mb-0">Scan oleh Admin</p>
                                </label>
                            </div>
                            <div class="col-6">
                                <label for="metode_mulai_mandiri" class="w-100 p-3 rounded-4 border-2 cursor-pointer text-center" style="border: 2px solid #198754; cursor: pointer;">
                                    <input type="radio" name="metode_radio" id="metode_mulai_mandiri" value="mandiri" class="d-none">
                                    <i class="fas fa-pen fa-2x text-success d-block mb-2"></i>
                                    <span class="fw-bold text-success">Mandiri</span>
                                    <p class="small text-muted mb-0">Input oleh Anggota</p>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 rounded-3 py-3 fw-bold" onclick="setMetode('metode_mulai', 'Sesi Mulai')">
                            <i class="fas fa-play-circle me-1"></i> MULAI SESI
                        </button>
                    </form>
                    <script>
                        function setMetode(inputId, sesiName) {
                            const metode = document.querySelector('input[name="metode_radio"]:checked');
                            if (!metode) {
                                event.preventDefault();
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    text: 'Pilih metode absensi terlebih dahulu untuk ' + sesiName,
                                    confirmButtonColor: '#048E8E'
                                });
                                return false;
                            }
                            document.getElementById(inputId).value = metode.value;
                            return true;
                        }
                        document.querySelectorAll('input[name="metode_radio"]').forEach(function(radio) {
                            radio.closest('label').addEventListener('click', function() {
                                document.querySelectorAll('[name="metode_radio"]').forEach(function(r) {
                                    r.closest('label').style.backgroundColor = '';
                                    r.closest('label').style.borderColor = r.value === 'qr_code' ? '#0d6efd' : '#198754';
                                });
                                radio.closest('label').style.backgroundColor = radio.value === 'qr_code' ? '#e7f1ff' : '#d1f7e3';
                                radio.closest('label').style.borderColor = '#198754';
                            });
                        });
                    </script>
                @endif
            </div>
        </div>
    </div>

    <!-- Sesi Selesai -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-info"><i class="fas fa-sign-out-alt me-2"></i>Sesi Selesai</h6>
            </div>
            <div class="card-body">
                @if($sesi_selesai)
                    <div class="text-center mb-4 py-3">
                        <div class="mb-3">
                            @if($sesi_selesai->status_sesi == 'berlangsung')
                                <div class="spinner-grow text-info" role="status" style="width: 3rem; height: 3rem;"></div>
                                <h5 class="mt-3 fw-bold text-info">Sesi Berlangsung</h5>
                            @else
                                <i class="fas fa-check-double fa-4x text-muted mb-3"></i>
                                <h5 class="fw-bold text-muted">Sesi Selesai</h5>
                            @endif
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-4 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Metode</span>
                            <span class="badge bg-info-subtle text-info px-3">{{ ucfirst($sesi_selesai->metode) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Waktu Mulai</span>
                            <span class="fw-bold small">{{ $sesi_selesai->dimulai_at->format('H:i:s d M Y') }}</span>
                        </div>
                        @if($sesi_selesai->status_sesi == 'selesai')
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Waktu Selesai</span>
                            <span class="fw-bold small">{{ $sesi_selesai->diselesaikan_at->format('H:i:s d M Y') }}</span>
                        </div>
                        @endif
                    </div>

                    @if($sesi_selesai->status_sesi == 'berlangsung')
                        <div class="d-grid gap-2">
                            <form action="{{ route('absensi.sesi-akhiri', $kegiatan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipe_sesi" value="selesai">
                                <button type="submit" class="btn btn-danger w-100 rounded-3 shadow-sm confirm-dialog" data-text="Akhiri sesi selesai?" title="Akhiri Sesi">
                                    <i class="fas fa-stop-circle me-1"></i> Akhiri Sesi
                                </button>
                            </form>
                            @if($sesi_selesai->metode == 'qr_code')
                                <a href="{{ route('absensi.qr', $kegiatan->id) }}" class="btn btn-info text-white rounded-3 shadow-sm">
                                    <i class="fas fa-qrcode me-1"></i> Buka QR Scanner
                                </a>
                            @endif
                        </div>
                    @endif
                @else
                    <div class="text-center py-4 mb-3">
                        <i class="fas fa-door-closed fa-4x text-muted opacity-10 mb-3"></i>
                        <h6 class="text-muted">Sesi selesai belum dibuka.</h6>
                    </div>
                    <form action="{{ route('absensi.sesi-mulai', $kegiatan->id) }}" method="POST" id="formSelesai">
                        @csrf
                        <input type="hidden" name="tipe_sesi" value="selesai">
                        <input type="hidden" name="metode" id="metode_selesai" value="">
                        <p class="text-muted small fw-bold mb-3">PILIH METODE ABSENSI</p>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="metode_selesai_qr" class="w-100 p-3 rounded-4 border-2 cursor-pointer text-center" style="border: 2px solid #0d6efd; cursor: pointer;">
                                    <input type="radio" name="metode_radio_selesai" id="metode_selesai_qr" value="qr_code" class="d-none">
                                    <i class="fas fa-qrcode fa-2x text-primary d-block mb-2"></i>
                                    <span class="fw-bold text-primary">QR Code</span>
                                    <p class="small text-muted mb-0">Scan oleh Admin</p>
                                </label>
                            </div>
                            <div class="col-6">
                                <label for="metode_selesai_mandiri" class="w-100 p-3 rounded-4 border-2 cursor-pointer text-center" style="border: 2px solid #198754; cursor: pointer;">
                                    <input type="radio" name="metode_radio_selesai" id="metode_selesai_mandiri" value="mandiri" class="d-none">
                                    <i class="fas fa-pen fa-2x text-success d-block mb-2"></i>
                                    <span class="fw-bold text-success">Mandiri</span>
                                    <p class="small text-muted mb-0">Input oleh Anggota</p>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info w-100 rounded-3 py-3 fw-bold text-white" onclick="setMetodeSelesai()">
                            <i class="fas fa-play-circle me-1"></i> MULAI SESI
                        </button>
                    </form>
                    <script>
                        function setMetodeSelesai() {
                            const metode = document.querySelector('input[name="metode_radio_selesai"]:checked');
                            if (!metode) {
                                event.preventDefault();
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Perhatian',
                                    text: 'Pilih metode absensi terlebih dahulu untuk Sesi Selesai',
                                    confirmButtonColor: '#048E8E'
                                });
                                return false;
                            }
                            document.getElementById('metode_selesai').value = metode.value;
                            return true;
                        }
                        document.querySelectorAll('input[name="metode_radio_selesai"]').forEach(function(radio) {
                            radio.closest('label').addEventListener('click', function() {
                                document.querySelectorAll('[name="metode_radio_selesai"]').forEach(function(r) {
                                    r.closest('label').style.backgroundColor = '';
                                    r.closest('label').style.borderColor = r.value === 'qr_code' ? '#0d6efd' : '#198754';
                                });
                                radio.closest('label').style.backgroundColor = radio.value === 'qr_code' ? '#e7f1ff' : '#d1f7e3';
                                radio.closest('label').style.borderColor = '#198754';
                            });
                        });
                    </script>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12 text-center">
        <a href="{{ route('absensi.rekap', $kegiatan->id) }}" class="btn btn-outline-primary px-4 py-2 rounded-3 fw-bold">
            <i class="fas fa-list-alt me-2"></i> LIHAT REKAP KEHADIRAN
        </a>
    </div>
</div>
@endsection
