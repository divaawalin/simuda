<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Konten;
use Illuminate\Support\Facades\Auth;

class AnggotaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $kegiatans = Kegiatan::whereIn('id', function ($query) use ($user) {
            $query->select('kegiatan_id')
                ->from('absensi_invite')
                ->where('user_id', $user->id);
        })->latest()->paginate(5, ['*'], 'kegiatanPage'); // Paginate kegiatans

        $kehadiranHariIni = Absensi::where('user_id', $user->id)
            ->whereDate('waktu_absen', today())
            ->count();

        $konten = Konten::latest()->paginate(5, ['*'], 'kontenPage'); // Paginate konten

        return view('anggota.dashboard', compact('konten', 'kegiatans', 'kehadiranHariIni'));
    }
}
