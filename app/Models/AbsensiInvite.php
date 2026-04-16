<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiInvite extends Model
{
    use HasFactory;

    protected $table = 'absensi_invite';

    protected $fillable = [
        'kegiatan_id',
        'user_id',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
