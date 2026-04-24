<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AbsensiExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiSesi;
use App\Models\Kegiatan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::latest()->get();

        return view('admin.export.index', compact('kegiatans'));
    }

    public function exportPdf(Request $request)
    {
        $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);
        $sesiMulai = AbsensiSesi::where('kegiatan_id', $kegiatan->id)->where('tipe_sesi', 'mulai')->first();
        $sesiSelesai = AbsensiSesi::where('kegiatan_id', $kegiatan->id)->where('tipe_sesi', 'selesai')->first();

        $invited = \DB::table('absensi_invite')->where('kegiatan_id', $kegiatan->id)->pluck('user_id');
        $users = User::whereIn('id', $invited)->get();

        foreach ($users as $user) {
            $user->absen_mulai = Absensi::where('absensi_sesi_id', optional($sesiMulai)->id)->where('user_id', $user->id)->first();
            $user->absen_selesai = Absensi::where('absensi_sesi_id', optional($sesiSelesai)->id)->where('user_id', $user->id)->first();
        }

        $pdf = Pdf::loadView('admin.export.pdf', compact('kegiatan', 'users', 'sesiMulai', 'sesiSelesai'));

        return $pdf->download('rekap-absensi-'.$kegiatan->id.'.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new AbsensiExport($request->kegiatan_id), 'rekap-absensi.xlsx');
    }
}
