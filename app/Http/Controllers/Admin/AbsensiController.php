<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiInvite;
use App\Models\AbsensiSesi;
use App\Models\Kegiatan;
use App\Models\User;
use App\Services\AttendanceService; // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AbsensiController extends Controller
{
    /**
     * Step 1 — Pilih Kegiatan
     */
    public function index()
    {
        $kegiatans = Kegiatan::latest()->get();

        return view('admin.absensi.index', compact('kegiatans'));
    }

    /**
     * Step 2 — Halaman invite anggota
     */
    public function invite($kegiatan_id)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);
        $anggota = User::where('role', 'anggota')->where('status', 'aktif')->get();
        $invited_ids = AbsensiInvite::where('kegiatan_id', $kegiatan_id)->pluck('user_id')->toArray();

        return view('admin.absensi.invite', compact('kegiatan', 'anggota', 'invited_ids'));
    }

    /**
     * Simpan daftar anggota yang diinvite
     */
    public function storeInvite(Request $request, $kegiatan_id)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        // Hapus invite lama
        AbsensiInvite::where('kegiatan_id', $kegiatan_id)->delete();

        // Simpan invite baru
        if ($request->has('user_ids')) {
            foreach ($request->user_ids as $user_id) {
                AbsensiInvite::create([
                    'kegiatan_id' => $kegiatan_id,
                    'user_id' => $user_id,
                ]);
            }
        }

        return redirect()->route('absensi.index')->with('success', 'Anggota berhasil diinvite ke kegiatan.');
    }

    /**
     * Step 3 — Halaman kelola sesi absensi
     */
    public function sesi($kegiatan_id)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        // Cek sesi mulai
        $sesi_mulai = AbsensiSesi::where('kegiatan_id', $kegiatan_id)
            ->where('tipe_sesi', 'mulai')
            ->first();

        // Cek sesi selesai
        $sesi_selesai = AbsensiSesi::where('kegiatan_id', $kegiatan_id)
            ->where('tipe_sesi', 'selesai')
            ->first();

        return view('admin.absensi.sesi', compact('kegiatan', 'sesi_mulai', 'sesi_selesai'));
    }

    /**
     * Mulai sesi absensi (mulai/selesai)
     */
    public function mulaiSesi(Request $request, $kegiatan_id)
    {
        $request->validate([
            'tipe_sesi' => 'required|in:mulai,selesai',
            'metode' => 'required|in:mandiri,qr_code',
        ]);

        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        // Pastikan sesi belum ada atau belum dimulai
        $existing_sesi = AbsensiSesi::where('kegiatan_id', $kegiatan_id)
            ->where('tipe_sesi', $request->tipe_sesi)
            ->first();

        if ($existing_sesi) {
            return back()->with('error', 'Sesi ini sudah pernah dibuat.');
        }

        $sesi = new AbsensiSesi;
        $sesi->kegiatan_id = $kegiatan_id;
        $sesi->tipe_sesi = $request->tipe_sesi;
        $sesi->metode = $request->metode;
        $sesi->status_sesi = 'berlangsung';

        if ($request->metode === 'qr_code') {
            $sesi->qr_token = Str::random(40);
            $sesi->qr_expires_at = now()->addHours(5); // Default 5 jam
        }

        $sesi->dimulai_oleh = Auth::id();
        $sesi->dimulai_at = now();
        $sesi->save();

        return back()->with('success', 'Sesi absensi berhasil dimulai.');
    }

    /**
     * Akhiri sesi absensi
     */
    public function akhiriSesi(Request $request, $kegiatan_id)
    {
        $request->validate([
            'tipe_sesi' => 'required|in:mulai,selesai',
        ]);

        $sesi = AbsensiSesi::where('kegiatan_id', $kegiatan_id)
            ->where('tipe_sesi', $request->tipe_sesi)
            ->where('status_sesi', 'berlangsung')
            ->firstOrFail();

        $sesi->status_sesi = 'selesai';
        $sesi->diselesaikan_oleh = Auth::id();
        $sesi->diselesaikan_at = now();
        $sesi->save();

        return back()->with('success', 'Sesi absensi berhasil diakhiri.');
    }

    /**
     * Tampilkan QR Code (jika metode QR)
     */
    public function qr($kegiatan_id)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        // Cari sesi yang sedang berlangsung dan menggunakan QR
        $sesi = AbsensiSesi::where('kegiatan_id', $kegiatan_id)
            ->where('status_sesi', 'berlangsung')
            ->where('metode', 'qr_code')
            ->first();

        if (! $sesi) {
            return redirect()->route('absensi.sesi', $kegiatan_id)->with('error', 'Tidak ada sesi QR yang sedang berlangsung.');
        }

        return view('admin.absensi.qr-scanner', compact('kegiatan', 'sesi'));
    }

    /**
     * Proses scan QR Code dari anggota
     */
    public function scan(Request $request, $kegiatan_id)
    {
        $request->validate([
            'qr_data' => 'required', // Data dari QR Anggota (berisi user_id)
        ]);

        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        // Cari sesi yang sedang berlangsung
        $sesi = AbsensiSesi::where('kegiatan_id', $kegiatan_id)
            ->where('status_sesi', 'berlangsung')
            ->where('metode', 'qr_code')
            ->first();

        if (! $sesi) {
            return response()->json(['success' => false, 'message' => 'Tidak ada sesi QR yang sedang berlangsung.'], 400);
        }

        // Parse QR Data anggota (asumsi data adalah JSON string {"user_id": 1, "kegiatan_id": 1})
        $data = json_decode($request->qr_data);
        if (! $data || ! isset($data->user_id)) {
            return response()->json(['success' => false, 'message' => 'Format QR tidak valid.'], 400);
        }

        $user_id = $data->user_id;

        // Cek apakah anggota diinvite
        $is_invited = AbsensiInvite::where('kegiatan_id', $kegiatan_id)->where('user_id', $user_id)->exists();
        if (! $is_invited) {
            return response()->json(['success' => false, 'message' => 'Anggota tidak terdaftar dalam kegiatan ini.'], 400);
        }

        // Cek apakah sudah absen
        $already_absen = Absensi::where('absensi_sesi_id', $sesi->id)->where('user_id', $user_id)->exists();
        if ($already_absen) {
            return response()->json(['success' => false, 'message' => 'Anggota sudah melakukan absensi.'], 400);
        }

        // Simpan absensi
        Absensi::create([
            'kegiatan_id' => $kegiatan_id,
            'absensi_sesi_id' => $sesi->id,
            'user_id' => $user_id,
            'tipe_sesi' => $sesi->tipe_sesi,
            'waktu_absen' => now(),
            'metode' => 'qr_code',
            'status' => 'hadir',
        ]);

        $user = User::find($user_id);

        return response()->json(['success' => true, 'message' => 'Absensi berhasil: '.$user->name]);
    }

    /**
     * Rekap absensi kegiatan
     */
    public function rekap($kegiatan_id, AttendanceService $attendanceService)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);
        $invited_users = User::whereIn('id', function ($query) use ($kegiatan_id) {
            $query->select('user_id')->from('absensi_invite')->where('kegiatan_id', $kegiatan_id);
        })->get();

        $sesi_mulai = AbsensiSesi::where('kegiatan_id', $kegiatan_id)->where('tipe_sesi', 'mulai')->first();
        $sesi_selesai = AbsensiSesi::where('kegiatan_id', $kegiatan_id)->where('tipe_sesi', 'selesai')->first();

        foreach ($invited_users as $user) {
            $user->absen_mulai = Absensi::where('absensi_sesi_id', optional($sesi_mulai)->id)
                ->where('user_id', $user->id)
                ->first();

            $user->absen_selesai = Absensi::where('absensi_sesi_id', optional($sesi_selesai)->id)
                ->where('user_id', $user->id) // Corrected from user->id to user_id
                ->first();

            $user->attendance_percentage = $attendanceService->calculateUserActivityAttendancePercentage($user, $kegiatan);
        }

        $totalDiundang = $invited_users->count();
        $mulaiHadir = $invited_users->filter(fn ($user) => ! is_null($user->absen_mulai))->count();
        $selesaiHadir = $invited_users->filter(fn ($user) => ! is_null($user->absen_selesai))->count();

        $persenMulai = $totalDiundang > 0 ? round(($mulaiHadir / $totalDiundang) * 100, 1) : 0;
        $persenSelesai = $totalDiundang > 0 ? round(($selesaiHadir / $totalDiundang) * 100, 1) : 0;

        return view('admin.absensi.rekap', compact('kegiatan', 'invited_users', 'sesi_mulai', 'sesi_selesai', 'persenMulai', 'persenSelesai', 'mulaiHadir', 'selesaiHadir', 'totalDiundang'));
    }

    /**
     * Rekap global semua kegiatan (pertahun/perbulan)
     */
    public function rekapGlobal(Request $request, AttendanceService $attendanceService)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        $query = Kegiatan::whereYear('tanggal_keg', $year);

        if ($month) {
            $query->whereMonth('tanggal_keg', $month);
        }

        $kegiatans = $query->orderBy('tanggal_keg', 'desc')->get();

        $data = [];
        $totalOverallInvited = 0;
        $totalOverallAttended = 0;

        foreach ($kegiatans as $kegiatan) {
            $invitedUserIds = AbsensiInvite::where('kegiatan_id', $kegiatan->id)->pluck('user_id')->unique();
            $totalInvited = $invitedUserIds->count();

            $attendedUserIds = Absensi::where('kegiatan_id', $kegiatan->id)
                                    ->where('status', 'hadir')
                                    ->whereIn('user_id', $invitedUserIds) // Only consider invited users
                                    ->pluck('user_id')
                                    ->unique();
            $totalAttended = $attendedUserIds->count();

            $attendancePercentage = ($totalInvited > 0) ? round(($totalAttended / $totalInvited) * 100, 2) : 0.0;

            $data[] = [
                'kegiatan' => $kegiatan,
                'total_invited' => $totalInvited,
                'total_attended' => $totalAttended,
                'attendance_percentage' => $attendancePercentage,
            ];

            $totalOverallInvited += $totalInvited;
            $totalOverallAttended += $totalAttended;
        }

        $overallGlobalPercentage = ($totalOverallInvited > 0) ? round(($totalOverallAttended / $totalOverallInvited) * 100, 2) : 0.0;

        $years = Kegiatan::selectRaw('YEAR(tanggal_keg) as year')->distinct()->pluck('year');

        return view('admin.absensi.rekap-global', compact('data', 'year', 'month', 'overallGlobalPercentage', 'years'));
    }
}
