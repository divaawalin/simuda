@extends('layouts.app')

@section('content')
<div class="dashboard-header">
    <h1>Dashboard Admin</h1>
    <p>Selamat datang di sistem manajemen organisasi SIMUDA.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Anggota</h3>
        <p>{{ $totalAnggota }}</p>
    </div>
    <div class="stat-card">
        <h3>Total Kegiatan</h3>
        <p>{{ $totalKegiatan }}</p>
    </div>
    <div class="stat-card">
        <h3>Absensi Hari Ini</h3>
        <p>{{ $absensiHariIni }}</p>
    </div>
</div>

<div class="card" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    <h2 style="margin-top: 0; color: #2c3e50;">Aktivitas Terbaru</h2>
    <p style="color: #7f8c8d;">Belum ada aktivitas terbaru untuk ditampilkan.</p>
</div>
@endsection
