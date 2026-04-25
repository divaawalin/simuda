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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AbsensiController extends Controller
{
    /**
     * Step 1 — Pilih Kegiatan
     */
    public function index(Request $request)
    {
        $kegiatans = Kegiatan::latest()->paginate(10);

        return view('admin.absensi.index', compact('kegiatans'));
    }

    /**
     * Step 2 — Halaman invite anggota
     */
    public function invite(Request $request, $kegiatan_id)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);
        $anggota = User::where('role', 'anggota')->where('status', 'aktif')->paginate(10);
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
    public function rekap($kegiatan_id, AttendanceService $attendanceService, Request $request)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan_id);

        // Fetch all invited users
        $all_invited_users = User::whereIn('id', function ($query) use ($kegiatan_id) {
            $query->select('user_id')->from('absensi_invite')->where('kegiatan_id', $kegiatan_id);
        })->get();

        $sesi_mulai = AbsensiSesi::where('kegiatan_id', $kegiatan_id)->where('tipe_sesi', 'mulai')->first();
        $sesi_selesai = AbsensiSesi::where('kegiatan_id', $kegiatan_id)->where('tipe_sesi', 'selesai')->first();

        // Get all attendance records for this activity
        $attendanceRecords = Absensi::where('kegiatan_id', $kegiatan_id)
            ->whereIn('user_id', $all_invited_users->pluck('id'))
            ->get();

        // Count by status (sakit counted as izin)
        $totalHadir = $attendanceRecords->where('status', 'hadir')->unique('user_id')->count();
        $totalIzin = $attendanceRecords->whereIn('status', ['izin', 'sakit'])->unique('user_id')->count();
        $totalAlfa = $attendanceRecords->where('status', 'alfa')->unique('user_id')->count();

        // Overall percentage (hadir / total invited)
        $totalDiundang = $all_invited_users->count();
        $overallPercentage = $totalDiundang > 0 ? round(($totalHadir / $totalDiundang) * 100, 2) : 0;

        // Session-specific counts
        $mulaiHadir = $all_invited_users->filter(fn ($user) => ! is_null($user->absen_mulai))->count();
        $selesaiHadir = $all_invited_users->filter(fn ($user) => ! is_null($user->absen_selesai))->count();

        // Per-user detailed attendance
        foreach ($all_invited_users as $user) {
            $user->absen_mulai = $attendanceRecords->firstWhere('user_id', $user->id);
            $user->absen_selesai = $attendanceRecords->firstWhere('user_id', $user->id);
            $user->attendance_percentage = $attendanceService->calculateUserActivityAttendancePercentage($user, $kegiatan);
        }

        // Summary stats
        $summary = [
            'total_invited' => $totalDiundang,
            'total_hadir' => $totalHadir,
            'total_izin' => $totalIzin,
            'total_alfa' => $totalAlfa,
            'overall_percentage' => $overallPercentage,
            'mulai_hadir' => $mulaiHadir,
            'selesai_hadir' => $selesaiHadir,
        ];

        // Best division
        $divisiStats = $all_invited_users->groupBy('divisi')->map(function($users, $divisi) use ($attendanceRecords) {
            $divisiUserIds = $users->pluck('id');
            $hadir = $attendanceRecords->whereIn('user_id', $divisiUserIds)->where('status', 'hadir')->unique('user_id')->count();
            $count = $users->count();
            $percent = $count > 0 ? round(($hadir / $count) * 100, 1) : 0;
            return [
                'divisi' => $divisi,
                'total' => $count,
                'hadir' => $hadir,
                'percentage' => $percent,
            ];
        })->sortByDesc('percentage');

        $summary['best_divisi'] = $divisiStats->first();
        $summary['divisi_breakdown'] = $divisiStats;

        // Paginate
        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage();
        $pagedData = $all_invited_users->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $invited_users = new LengthAwarePaginator(
            $pagedData,
            $all_invited_users->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url()]
        );

        return view('admin.absensi.rekap', compact(
            'kegiatan',
            'invited_users',
            'sesi_mulai',
            'sesi_selesai',
            'summary',
            'divisiStats'
        ));
    }

    /**
     * Rekap global semua kegiatan (pertahun/perbulan)
     */
    public function rekapGlobal(Request $request, AttendanceService $attendanceService)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');
        $divisionFilter = $request->get('division');
        $activityFilter = $request->get('activity');

        $query = Kegiatan::whereYear('tanggal', $year);

        if ($month) {
            $query->whereMonth('tanggal', $month);
        }

        if ($activityFilter) {
            $query->where('nama_kegiatan', 'like', "%{$activityFilter}%");
        }

        $kegiatans = $query->orderBy('tanggal', 'desc')->get();

        // Filter by division if selected - filter kegiatan to only those with invited members from that division
        if ($divisionFilter) {
            $kegiatanIdsWithDivision = AbsensiInvite::whereIn('user_id', function($q) use ($divisionFilter) {
                $q->select('id')->from('users')->where('role', 'anggota')->where('divisi', $divisionFilter);
            })->pluck('kegiatan_id')->unique();

            $kegiatans = $kegiatans->whereIn('id', $kegiatanIdsWithDivision);
        }

        // Get IDs of all selected kegiatan for later use
        $kegiatanIds = $kegiatans->pluck('id');

        $allRecapData = collect();
        $totalOverallInvited = 0;
        $totalOverallHadir = 0;
        $totalOverallIzin = 0;
        $totalOverallAlfa = 0;

        $allAttendanceRecords = collect(); // Collect all attendance for division analysis

        foreach ($kegiatans as $kegiatan) {
            $invitedUserIds = AbsensiInvite::where('kegiatan_id', $kegiatan->id)->pluck('user_id')->unique();
            $totalInvited = $invitedUserIds->count();

            // Get attendance records for invited users only
            $attendanceRecords = Absensi::where('kegiatan_id', $kegiatan->id)
                ->whereIn('user_id', $invitedUserIds)
                ->get();

            // Accumulate all attendance records across all activities
            $allAttendanceRecords = $allAttendanceRecords->merge($attendanceRecords);

            // Count by status (sakit counted as izin)
            $hadirCount = $attendanceRecords->where('status', 'hadir')->unique('user_id')->count();
            $izinCount = $attendanceRecords->whereIn('status', ['izin', 'sakit'])->unique('user_id')->count();
            $alfaCount = $attendanceRecords->where('status', 'alfa')->unique('user_id')->count();

            $attendancePercentage = ($totalInvited > 0) ? round(($hadirCount / $totalInvited) * 100, 2) : 0.0;
            $hadirPercent = ($totalInvited > 0) ? round(($hadirCount / $totalInvited) * 100, 1) : 0;
            $izinPercent = ($totalInvited > 0) ? round(($izinCount / $totalInvited) * 100, 1) : 0;
            $alfaPercent = ($totalInvited > 0) ? round(($alfaCount / $totalInvited) * 100, 1) : 0;

            $allRecapData->push([
                'kegiatan' => $kegiatan,
                'total_invited' => $totalInvited,
                'total_hadir' => $hadirCount,
                'total_izin' => $izinCount,
                'total_alfa' => $alfaCount,
                'attendance_percentage' => $attendancePercentage,
                'hadir_percent' => $hadirPercent,
                'izin_percent' => $izinPercent,
                'alfa_percent' => $alfaPercent,
            ]);

            $totalOverallInvited += $totalInvited;
            $totalOverallHadir += $hadirCount;
            $totalOverallIzin += $izinCount;
            $totalOverallAlfa += $alfaCount;
        }

        // Calculate overall percentages for pie chart
        $overallHadirPercent = ($totalOverallInvited > 0) ? round(($totalOverallHadir / $totalOverallInvited) * 100, 2) : 0.0;
        $overallIzinPercent = ($totalOverallInvited > 0) ? round(($totalOverallIzin / $totalOverallInvited) * 100, 2) : 0.0;
        $overallAlfaPercent = ($totalOverallInvited > 0) ? round(($totalOverallAlfa / $totalOverallInvited) * 100, 2) : 0.0;

        // Summary statistics
        $summary = [
            'avg_attendance' => $allRecapData->avg('attendance_percentage') ?? 0,
            'best_kegiatan' => $allRecapData->sortByDesc('attendance_percentage')->first(),
            'worst_kegiatan' => $allRecapData->sortBy('attendance_percentage')->first(),
            'total_kegiatan' => $allRecapData->count(),
            'total_anggota' => $totalOverallInvited,
        ];

        // Additional member-based stats
        $kegiatanIds = $kegiatans->pluck('id');

        $topAttendee = User::where('role', 'anggota')
            ->withCount(['absensi as total_hadir' => function($q) use ($kegiatanIds) {
                $q->whereIn('kegiatan_id', $kegiatanIds)
                  ->where('status', 'hadir');
            }])
            ->orderBy('total_hadir', 'desc')
            ->first();

        $topAlfaMember = User::where('role', 'anggota')
            ->withCount(['absensi as total_alfa' => function($q) use ($kegiatanIds) {
                $q->whereIn('kegiatan_id', $kegiatanIds)
                  ->where('status', 'alfa');
            }])
            ->orderBy('total_alfa', 'desc')
            ->first();

        $summary['top_attendee'] = $topAttendee;
        $summary['top_alfa_member'] = $topAlfaMember;

        // Monthly trend data for the year (group from allRecapData)
        $monthlyTrend = $allRecapData->groupBy(function($item) {
            return \Carbon\Carbon::parse($item['kegiatan']->tanggal)->month;
        })->map(function($items, $month) {
            $totalInvited = collect($items)->sum('total_invited');
            $totalHadir = collect($items)->sum('total_hadir');
            $percentage = $totalInvited > 0 ? round(($totalHadir / $totalInvited) * 100, 1) : 0;
            return [
                'month' => (int)$month,
                'month_name' => \Carbon\Carbon::create()->month((int)$month)->shortMonthName,
                'invited' => $totalInvited,
                'hadir' => $totalHadir,
                'percentage' => $percentage,
            ];
        })->sortBy('month')->values();

        $summary['monthly_trend'] = $monthlyTrend;

        // Division comparison (filtered by selected division if applicable)
        $anggotaQuery = User::where('role', 'anggota');
        if ($divisionFilter) {
            $anggotaQuery->where('divisi', $divisionFilter);
        }
        $filteredAnggota = $anggotaQuery->get();

        // Get invited users among filtered
        $invitedInPeriod = $filteredAnggota->whereIn('id', AbsensiInvite::whereIn('kegiatan_id', $kegiatanIds)->pluck('user_id')->unique());

        $divisionData = $invitedInPeriod->groupBy('divisi')->map(function($users, $divisi) use ($allAttendanceRecords) {
            $userIds = $users->pluck('id');
            $invited = $users->count();
            $hadir = $allAttendanceRecords->whereIn('user_id', $userIds)->where('status', 'hadir')->unique('user_id')->count();
            $izin = $allAttendanceRecords->whereIn('user_id', $userIds)->whereIn('status', ['izin', 'sakit'])->unique('user_id')->count();
            $alfa = $allAttendanceRecords->whereIn('user_id', $userIds)->where('status', 'alfa')->unique('user_id')->count();
            return [
                'divisi' => $divisi,
                'invited' => $invited,
                'hadir' => $hadir,
                'izin' => $izin,
                'alfa' => $alfa,
                'percentage' => $invited > 0 ? round(($hadir / $invited) * 100, 1) : 0,
            ];
        })->sortByDesc('percentage')->values();

        if ($divisionData->isEmpty()) {
            $divisionData = collect([[
                'divisi' => $selectedDivision ?? 'Tidak Ada Data',
                'invited' => 0,
                'hadir' => 0,
                'izin' => 0,
                'alfa' => 0,
                'percentage' => 0,
            ]]);
        }

        $summary['division_comparison'] = $divisionData;

        $years = Kegiatan::selectRaw('YEAR(tanggal) as year')->distinct()->pluck('year');
        $divisions = User::where('role', 'anggota')->distinct()->pluck('divisi');

        // Manually paginate the collection
        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage();
        $pagedData = $allRecapData->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $data = new LengthAwarePaginator(
            $pagedData,
            $allRecapData->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url()]
        );

        return view('admin.absensi.rekap-global', compact('data', 'allRecapData', 'year', 'month', 'divisionFilter', 'activityFilter', 'overallHadirPercent', 'overallIzinPercent', 'overallAlfaPercent', 'summary', 'years', 'divisions'));
    }
}
