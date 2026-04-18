@extends('layouts.app')

@section('page-title', 'Scanner Absensi Anggota')

@section('content')
<div class="container-fluid px-0">
    <div class="page-banner mb-4">
        <div class="page-banner-content">
            <div class="page-banner-copy">
                <div class="page-banner-icon"><i class="fas fa-qrcode"></i></div>
                <div>
                    <h4 class="fw-bold">Scanner Absensi Anggota</h4>
                    <p>Gunakan kamera untuk membaca QR anggota pada kegiatan <strong>{{ $kegiatan->nama_kegiatan }}</strong>.</p>
                </div>
            </div>
            <a href="{{ route('absensi.sesi', $kegiatan->id) }}" class="btn btn-light px-4"><i class="fas fa-times me-2"></i>Tutup</a>
        </div>
    </div>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white py-3 text-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-qrcode me-2"></i> Scanner Absensi Anggota</h5>
            </div>
            <div class="card-body p-4 text-center">
                <p class="text-muted mb-4">Arahkan kamera ke QR Code yang ditampilkan pada device Anggota.</p>
                
                <div id="reader" class="rounded-4 shadow-sm" style="width: 100%; max-width: 400px; height: 300px; margin: 0 auto; overflow: hidden;"></div>
                
                <div id="result" class="mt-4 p-3 bg-light rounded-3 border-0 shadow-sm">
                    <p class="text-muted mb-0"><i class="fas fa-camera me-2"></i> Menunggu scan...</p>
                </div>

                <div id="statusMessage" class="mt-3 text-center" style="min-height: 50px;"></div>
            </div>
            <div class="card-footer bg-light p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 fw-bold text-dark">{{ $kegiatan->nama_kegiatan }}</h6>
                        <span class="badge bg-primary-subtle text-primary">{{ ucfirst($sesi->tipe_sesi) }} - {{ ucfirst($sesi->metode) }}</span>
                    </div>
                    <a href="{{ route('absensi.sesi', $kegiatan->id) }}" class="btn btn-secondary rounded-3">
                        <i class="fas fa-times me-1"></i> Tutup Scanner
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let html5QrcodeScanner;
    const statusMessageDiv = document.getElementById('statusMessage');
    const resultDiv = document.getElementById('result');

    function displayStatusMessage(message, isError = false) {
        statusMessageDiv.innerHTML = `
            <div class="alert ${isError ? 'alert-danger' : 'alert-success'} border-0 shadow-sm rounded-3 py-3 animate__animated animate__bounceIn">
                <i class="fas ${isError ? 'fa-times-circle' : 'fa-check-circle'} fa-2x mb-2 d-block"></i>
                <h5 class="fw-bold mb-1">${isError ? 'Gagal' : 'Berhasil'}</h5>
                <p class="mb-0">${message}</p>
            </div>
        `;
    }

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Scan result: ${decodedText}`);
        resultDiv.innerHTML = `<p class="text-primary fw-bold">Memproses...</p>`;
        html5QrcodeScanner.clear();

        fetch("{{ route('absensi.scan', $kegiatan->id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qr_data: decodedText })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                displayStatusMessage(data.message, false);
                // Play success sound
                const audio = new Audio('https://assets.mixkit.co/sfx/preview/mixkit-software-interface-start-2574.mp3');
                audio.play();
            } else {
                displayStatusMessage(data.message, true);
            }
            
            setTimeout(() => {
                location.reload();
            }, 3000);
        })
        .catch(error => {
            console.error('Error:', error);
            displayStatusMessage('Terjadi kesalahan sistem saat memproses absensi.', true);
            setTimeout(() => location.reload(), 3000);
        });
    }

    function onScanError(errorMessage) {
        console.error(`Scanner error: ${errorMessage}`);
        displayStatusMessage(`Kesalahan scanner: ${errorMessage}. Pastikan kamera aktif dan izin diberikan.`, true);
    }

    const config = {
        fps: 15,
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0,
        showZoomValue: true,
        useBarCodeDetectorIfSupported: true,
        rememberLastUsedCamera: true,
    };

    // Initialize scanner
    html5QrcodeScanner = new Html5QrcodeScanner("reader", config);

    // Render scanner and handle potential initialization errors
    html5QrcodeScanner.render(onScanSuccess, onScanError)
        .catch(err => {
            console.error("Scanner initialization error:", err);
            displayStatusMessage(`Gagal menginisialisasi scanner: ${err.message}. Pastikan kamera tersedia dan izin diberikan.`, true);
        });

    // Fallback check: If video element is not available after a delay, assume failure
    setTimeout(() => {
        const videoElement = document.getElementById('reader')?.querySelector('video');
        // Check if video element exists and is playing, or if an error message was already displayed
        if (statusMessageDiv.innerHTML === '' && (!videoElement || videoElement.readyState !== 4)) {
            displayStatusMessage("Tidak dapat menampilkan video kamera. Periksa izin kamera atau coba lagi.", true);
        }
    }, 7000); // Check after 7 seconds

</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endpush
