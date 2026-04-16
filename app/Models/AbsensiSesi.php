<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str for token generation

class AbsensiSesi extends Model
{
    use HasFactory;

    protected $table = 'absensi_sesi';

    protected $fillable = [
        'kegiatan_id',
        'tipe_sesi', // Assuming this might be 'mandiri' or 'qr_code' based on controller
        'metode',    // This seems more appropriate for the method in controller
        'status_sesi', // e.g., 'aktif', 'selesai'
        'qr_token',
        'qr_expires_at',
        'dimulai_oleh',
        'dimulai_at',
        'diselesaikan_oleh',
        'diselesaikan_at',
    ];

    protected $casts = [
        'dimulai_at' => 'datetime',
        'diselesaikan_at' => 'datetime',
        'qr_expires_at' => 'datetime',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function starter()
    {
        return $this->belongsTo(User::class, 'dimulai_oleh');
    }

    public function finisher()
    {
        return $this->belongsTo(User::class, 'diselesaikan_oleh');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Check if the attendance session is currently active.
     * An active session has a start time but no end time.
     * @return bool
     */
    public function isSessionActive(): bool
    {
        return $this->dimulai_at !== null && $this->diselesaikan_at === null;
    }

    /**
     * Generate a unique token for QR code attendance.
     * @return string
     */
    public static function generateQrToken(): string
    {
        // Generate a random string for the token
        return Str::random(40);
    }
}
