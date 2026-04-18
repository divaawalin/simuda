<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class KontenController extends Controller
{
    public function index()
    {
        $kontens = Konten::latest()->get();

        return view('admin.konten.index', compact('kontens'));
    }

    public function create()
    {
        return view('admin.konten.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_konten' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:gambar,file,link',
            'gambar_konten' => 'required_if:tipe,gambar|nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'dokumen_konten' => 'required_if:tipe,file|nullable|file|max:10240',
            'link_url' => 'required_if:tipe,link|nullable|url',
        ]);

        $data = $request->only(['nama_konten', 'deskripsi', 'tipe']);
        $data['created_by'] = Auth::id();

        $uploadedFile = $request->file('gambar_konten') ?: $request->file('dokumen_konten');

        if ($uploadedFile) {
            File::ensureDirectoryExists(storage_path('konten'));
            $fileName = time().'_'.uniqid().'.'.$uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(storage_path('konten'), $fileName);
            $data['file_path'] = $fileName;
        } else {
            $data['link_url'] = $request->link_url;
        }

        Konten::create($data);

        return redirect()->route('konten.index')->with('success', 'Konten berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $konten = Konten::findOrFail($id);

        return view('admin.konten.edit', compact('konten'));
    }

    public function update(Request $request, $id)
    {
        $konten = Konten::findOrFail($id);

        $request->validate([
            'nama_konten' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:gambar,file,link',
            'gambar_konten' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'dokumen_konten' => 'nullable|file|max:10240',
            'link_url' => 'required_if:tipe,link|nullable|url',
        ]);

        $data = $request->only(['nama_konten', 'deskripsi', 'tipe']);
        $oldTipe = $konten->tipe;
        $newTipe = $request->tipe;

        // Handle file deletion when switching away from file-based types
        if (in_array($oldTipe, ['gambar', 'file']) && $newTipe === 'link' && $konten->file_path) {
            if (File::exists(storage_path('konten/'.$konten->file_path))) {
                File::delete(storage_path('konten/'.$konten->file_path));
            }
            $data['file_path'] = null;
        }

        // Handle file upload
        $uploadedFile = $request->file('gambar_konten') ?: $request->file('dokumen_konten');

        if ($uploadedFile) {
            // Delete old file if exists and is different from new upload
            if ($konten->file_path && File::exists(storage_path('konten/'.$konten->file_path))) {
                File::delete(storage_path('konten/'.$konten->file_path));
            }
            File::ensureDirectoryExists(storage_path('konten'));
            $fileName = time().'_'.uniqid().'.'.$uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(storage_path('konten'), $fileName);
            $data['file_path'] = $fileName;
            $data['link_url'] = null;
        }
        // If switching between file-based types without file upload, clear file_path
        elseif (in_array($newTipe, ['gambar', 'file']) && $oldTipe !== $newTipe) {
            if ($konten->file_path && File::exists(storage_path('konten/'.$konten->file_path))) {
                File::delete(storage_path('konten/'.$konten->file_path));
            }
            $data['file_path'] = null;
        }

        // Handle link URL
        if ($newTipe === 'link') {
            $data['link_url'] = $request->link_url;
        } elseif ($newTipe !== 'link' && $oldTipe === 'link') {
            $data['link_url'] = null;
        }

        $konten->update($data);

        return redirect()->route('konten.index')->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $konten = Konten::findOrFail($id);

        if ($konten->file_path && File::exists(storage_path('konten/'.$konten->file_path))) {
            File::delete(storage_path('konten/'.$konten->file_path));
        }

        $konten->delete();

        return redirect()->route('konten.index')->with('success', 'Konten berhasil dihapus.');
    }
}
