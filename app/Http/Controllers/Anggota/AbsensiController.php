<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiInvite;
use App\Models\AbsensiSesi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Step 1 — Pilih Kegiatan
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Ambil kegiatan yang diinvite
        $kegiatans = Kegiatan::whereIn('id', function($query) use ($user) {
            $query->select('kegiatan_id')->from('absensi_invite')->where('user_id', $user->id);
        })->latest()->paginate(10);

        return view('anggota.absensi.index', compact('kegiatans'));
    }

    /**
     * Step 2 — Detail sesi absensi kegiatan
     */
    public function detail($kegiatan_id)
    {
        $user = Auth::user();
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        // Pastikan diinvite
        $is_invited = AbsensiInvite::where('kegiatan_id', $kegiatan_id)->where('user_id', $user->id)->exists();
        if (!$is_invited) {
            abort(403, 'Anda tidak diinvite ke kegiatan ini.');
        }

        $sesi_mulai = AbsensiSesi::where('kegiatan_id', $kegiatan_id)->where('tipe_sesi', 'mulai')->first();
        $sesi_selesai = AbsensiSesi::where('kegiatan_id', $kegiatan_id)->where('tipe_sesi', 'selesai')->first();

        // Cek apakah sudah absen
        $absen_mulai = Absensi::where('absensi_sesi_id', optional($sesi_mulai)->id)->where('user_id', $user->id)->first();
        $absen_selesai = Absensi::where('absensi_sesi_id', optional($sesi_selesai)->id)->where('user_id', $user->id)->first();

        return view('anggota.absensi.detail', compact('kegiatan', 'sesi_mulai', 'sesi_selesai', 'absen_mulai', 'absen_selesai'));
    }

    /**
     * Step 3 — Tampilkan QR Code anggota
     */
    public function qr($kegiatan_id)
    {
        $user = Auth::user();
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        // Data QR berisi user_id dan kegiatan_id
        $qrData = json_encode([
            'user_id' => $user->id,
            'kegiatan_id' => $kegiatan->id,
        ]);

        return view('anggota.absensi.qr', compact('kegiatan', 'qrData'));
    }

    /**
     * Submit absen mandiri
     */
    public function absen(Request $request, $kegiatan_id)
    {
        $request->validate([
            'tipe_sesi' => 'required|in:mulai,selesai',
        ]);

        $user = Auth::user();
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        // Cari sesi yang sedang berlangsung dan metode mandiri
        $sesi = AbsensiSesi::where('kegiatan_id', $kegiatan_id)
            ->where('tipe_sesi', $request->tipe_sesi)
            ->where('status_sesi', 'berlangsung')
            ->where('metode', 'mandiri')
            ->first();

        if (!$sesi) {
            return back()->with('error', 'Sesi absensi mandiri tidak tersedia atau belum dimulai.');
        }

        // Cek apakah sudah absen
        $already_absen = Absensi::where('absensi_sesi_id', $sesi->id)->where('user_id', $user->id)->exists();
        if ($already_absen) {
            return back()->with('error', 'Anda sudah melakukan absensi.');
        }

        // Simpan absensi
        Absensi::create([
            'kegiatan_id' => $kegiatan_id,
            'absensi_sesi_id' => $sesi->id,
            'user_id' => $user->id,
            'tipe_sesi' => $request->tipe_sesi,
            'waktu_absen' => now(),
            'metode' => 'mandiri',
            'status' => 'hadir',
        ]);

        return redirect()->route('anggota.absensi.detail', $kegiatan_id)->with('success', 'Absensi berhasil dicatat.');
    }
}
