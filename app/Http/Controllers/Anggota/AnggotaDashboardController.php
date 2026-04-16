<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Konten; // Ensure this model exists in app/Models/Konten.php

class AnggotaDashboardController extends Controller
{
    /**
     * Display the Anggota dashboard, fetching all konten entries.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $konten = Konten::all(); // Fetch all konten entries
        return view('anggota.dashboard', compact('konten'));
    }
}
