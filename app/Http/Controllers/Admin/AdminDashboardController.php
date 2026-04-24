<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalAnggota = User::where('role', 'anggota')->count();
        $totalKegiatan = Kegiatan::count();
        $today = Carbon::today();
        $absensiHariIni = Absensi::whereDate('waktu_absen', $today)->count();

        // Data for charts
        $kegiatanPerBulan = Kegiatan::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $absensiPerBulan = Absensi::selectRaw('MONTH(waktu_absen) as bulan, COUNT(*) as total')
            ->whereYear('waktu_absen', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $labels = [];
        $kegiatanData = [];
        $absensiData = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('M', mktime(0, 0, 0, $i, 1));
            $kegiatanData[] = $kegiatanPerBulan->where('bulan', $i)->first()->total ?? 0;
            $absensiData[] = $absensiPerBulan->where('bulan', $i)->first()->total ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalAnggota', 'totalKegiatan', 'absensiHariIni',
            'labels', 'kegiatanData', 'absensiData'
        ));
    }
}
