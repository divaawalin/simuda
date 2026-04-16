<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiSesi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminAbsensiController extends Controller // Renamed to avoid conflict if an AdminAbsensiController exists
{
    // This controller is not requested, but shown as an example if admin logic were needed.
    // The main request is for the AnggotaAbsensi feature.
}
