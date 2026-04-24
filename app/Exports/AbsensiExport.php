<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\AbsensiSesi;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kegiatanId;

    public function __construct($kegiatanId)
    {
        $this->kegiatanId = $kegiatanId;
    }

    public function collection()
    {
        $sesiMulai = AbsensiSesi::where('kegiatan_id', $this->kegiatanId)->where('tipe_sesi', 'mulai')->first();
        $sesiSelesai = AbsensiSesi::where('kegiatan_id', $this->kegiatanId)->where('tipe_sesi', 'selesai')->first();

        $invited = \DB::table('absensi_invite')->where('kegiatan_id', $this->kegiatanId)->pluck('user_id');

        return User::whereIn('id', $invited)->get();
    }

    public function headings(): array
    {
        return ['Nama', 'Email', 'Divisi', 'Hadir Mulai', 'Waktu Mulai', 'Hadir Selesai', 'Waktu Selesai'];
    }

    public function map($user): array
    {
        $sesiMulai = AbsensiSesi::where('kegiatan_id', $this->kegiatanId)->where('tipe_sesi', 'mulai')->first();
        $sesiSelesai = AbsensiSesi::where('kegiatan_id', $this->kegiatanId)->where('tipe_sesi', 'selesai')->first();

        $absenMulai = Absensi::where('absensi_sesi_id', optional($sesiMulai)->id)->where('user_id', $user->id)->first();
        $absenSelesai = Absensi::where('absensi_sesi_id', optional($sesiSelesai)->id)->where('user_id', $user->id)->first();

        return [
            $user->name,
            $user->email,
            $user->divisi,
            $absenMulai ? 'Hadir' : 'Tidak Hadir',
            $absenMulai ? $absenMulai->waktu_absen : '-',
            $absenSelesai ? 'Hadir' : 'Tidak Hadir',
            $absenSelesai ? $absenSelesai->waktu_absen : '-',
        ];
    }
}
