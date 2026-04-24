<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi - {{ $kegiatan->nama_kegiatan }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { color: #048e8e; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #048e8e; color: white; padding: 8px; text-align: left; }
        td { padding: 6px; border-bottom: 1px solid #ddd; }
        .header { margin-bottom: 20px; }
        .badge-hadir { color: green; }
        .badge-tidk { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rekap Absensi: {{ $kegiatan->nama_kegiatan }}</h1>
        <p>Tanggal: {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d F Y') }}</p>
        <p>Lokasi: {{ $kegiatan->lokasi }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Divisi</th>
                <th>Hadir Mulai</th>
                <th>Waktu Mulai</th>
                <th>Hadir Selesai</th>
                <th>Waktu Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->divisi }}</td>
                <td class="{{ $user->absen_mulai ? 'badge-hadir' : 'badge-tidk' }}">
                    {{ $user->absen_mulai ? 'Hadir' : 'Tidak' }}
                </td>
                <td>{{ optional($user->absen_mulai)->waktu_absen ? \Carbon\Carbon::parse($user->absen_mulai->waktu_absen)->format('H:i') : '-' }}</td>
                <td class="{{ $user->absen_selesai ? 'badge-hadir' : 'badge-tidk' }}">
                    {{ $user->absen_selesai ? 'Hadir' : 'Tidak' }}
                </td>
                <td>{{ optional($user->absen_selesai)->waktu_absen ? \Carbon\Carbon::parse($user->absen_selesai->waktu_absen)->format('H:i') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
