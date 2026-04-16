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

        return view('admin.dashboard', compact('totalAnggota', 'totalKegiatan', 'absensiHariIni'));
    }
}
