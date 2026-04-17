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
            'file_konten' => 'required_if:tipe,gambar,file|file|max:10240',
            'link_url' => 'required_if:tipe,link|nullable|url',
        ]);

        $data = $request->only(['nama_konten', 'deskripsi', 'tipe']);
        $data['created_by'] = Auth::id();

        if ($request->hasFile('file_konten')) {
            $file = $request->file('file_konten');
            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(storage_path('konten'), $fileName);
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
            'file_konten' => 'nullable|file|max:10240',
            'link_url' => 'required_if:tipe,link|nullable|url',
        ]);

        $data = $request->only(['nama_konten', 'deskripsi', 'tipe']);

        if ($request->hasFile('file_konten')) {
            if ($konten->file_path && File::exists(storage_path('konten/'.$konten->file_path))) {
                File::delete(storage_path('konten/'.$konten->file_path));
            }
            $file = $request->file('file_konten');
            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(storage_path('konten'), $fileName);
            $data['file_path'] = $fileName;
            $data['link_url'] = null;
        } elseif ($request->tipe === 'link') {
            if ($konten->file_path && File::exists(storage_path('konten/'.$konten->file_path))) {
                File::delete(storage_path('konten/'.$konten->file_path));
            }
            $data['file_path'] = null;
            $data['link_url'] = $request->link_url;
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
