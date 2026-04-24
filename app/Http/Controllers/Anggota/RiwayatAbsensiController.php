<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiSesi;
use Illuminate\Support\Facades\Auth;

class RiwayatAbsensiController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $riwayat = Absensi::with(['kegiatan', 'sesi'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        $totalHadir = Absensi::where('user_id', $userId)
            ->where('status', 'hadir')
            ->count();

        $totalSesi = AbsensiSesi::whereIn('kegiatan_id', function ($query) use ($userId) {
            $query->select('kegiatan_id')->from('absensi_invite')->where('user_id', $userId);
        })->count();

        $persentase = $totalSesi > 0 ? round(($totalHadir / $totalSesi) * 100, 1) : 0;

        return view('anggota.riwayat.index', compact('riwayat', 'totalHadir', 'totalSesi', 'persentase'));
    }
}
