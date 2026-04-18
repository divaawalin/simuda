<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Konten;

class KontenController extends Controller
{
    public function index()
    {
        $konten = Konten::latest()->get();

        return view('anggota.konten.index', compact('konten'));
    }
}
