<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'kegiatan_id',
        'absensi_sesi_id',
        'user_id',
        'tipe_sesi',
        'waktu_absen',
        'metode',
        'status',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function sesi()
    {
        return $this->belongsTo(AbsensiSesi::class, 'absensi_sesi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
