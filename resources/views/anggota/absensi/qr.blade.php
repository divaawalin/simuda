@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>QR Code Anda</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($qrData))
        <div id="qrcode"></div>
        <p class="mt-3">Tunjukkan QR code ini kepada admin untuk konfirmasi kehadiran.</p>
        <p class="text-muted">Kegiatan: {{ $kegiatan->name }}</p>
        <p class="text-muted">Anggota: {{ $user->name }}</p>

        {{-- QR Code Generation using a simple JavaScript library (e.g., qrcode.js) --}}
        {{-- You might need to include this library in your app.js or via CDN --}}
        {{-- For simplicity, assuming qrcode.js is available or can be included --}}
        {{-- If not, you might need a server-side QR code generator or a different JS library. --}}
        {{-- Example using a common CDN: --}}
        <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                var qrData = {!! $qrData !!};
                // Ensure the QR code library is loaded before using it
                if (window.QRCode) {
                    var qrcode = new QRCode(document.getElementById("qrcode"), {
                        text: JSON.stringify(qrData), // Encode the JSON data
                        width: 256,
                        height: 256,
                        colorDark : "#000000",
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.H
                    });
                } else {
                    console.error("QRCode.js library not loaded.");
                    // Optionally display a message to the user
                    document.getElementById("qrcode").innerHTML = "<p class='text-danger'>QR Code generator could not be loaded. Please check your internet connection or contact support.</p>";
                }
            });
        </script>
    @else
        <p class="text-danger">QR Code data could not be generated.</p>
    @endif
</div>
@endsection
