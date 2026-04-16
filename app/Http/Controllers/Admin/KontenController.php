<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Import Storage facade

class KontenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Assuming Konten model has a 'creator' relationship defined
        $kontens = Konten::with('creator')->latest()->paginate(10); // Using pagination for better performance
        return view('admin.konten.index', compact('kontens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.konten.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_konten' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:gambar,file,link',
            'file_konten' => 'required_if:tipe,gambar,file|file|max:10240', // max 10MB
            'link_url' => 'required_if:tipe,link|nullable|url',
        ]);

        $data = $request->only(['nama_konten', 'deskripsi', 'tipe']);
        $data['created_by'] = Auth::id(); // Set created_by to current user ID

        $disk = 'konten'; // Use the 'konten' disk

        if ($request->hasFile('file_konten')) {
            $file = $request->file('file_konten');
            // Store file and get its path (filename)
            // putFileAs(directory, file, filename)
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('', $fileName, $disk); // Store in the root of the 'konten' disk
            $data['file_path'] = $fileName; // Store only the filename
            $data['link_url'] = null; // Ensure link_url is null for file/gambar types
        } else if ($request->tipe === 'link') {
            $data['link_url'] = $request->link_url;
            $data['file_path'] = null; // Ensure file_path is null for link type
        } else {
            // For types that do not require file upload or link
            $data['file_path'] = null;
            $data['link_url'] = null;
        }

        Konten::create($data);

        // Adjust route for admin context if necessary, assuming 'konten.index' is defined in routes/web.php
        return redirect()->route('konten.index')->with('success', 'Konten berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $konten = Konten::findOrFail($id);
        return view('admin.konten.show', compact('konten'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $konten = Konten::findOrFail($id);
        return view('admin.konten.edit', compact('konten'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $konten = Konten::findOrFail($id);

        $request->validate([
            'nama_konten' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:gambar,file,link',
            'file_konten' => 'nullable|file|max:10240', // Only required if user uploads a new file
            'link_url' => 'required_if:tipe,link|nullable|url',
        ]);

        $data = $request->only(['nama_konten', 'deskripsi', 'tipe']);
        $disk = 'konten'; // Use the 'konten' disk

        if ($request->tipe === 'link') {
            $data['link_url'] = $request->link_url;
            $data['file_path'] = null;
            // Delete old file if it exists and is not a link type
            if ($konten->file_path && Storage::disk($disk)->exists($konten->file_path)) {
                Storage::disk($disk)->delete($konten->file_path);
            }
        } else { // tipe is 'gambar' or 'file'
            $data['link_url'] = null; // Ensure link_url is null
            if ($request->hasFile('file_konten')) {
                // Delete old file if it exists
                if ($konten->file_path && Storage::disk($disk)->exists($konten->file_path)) {
                    Storage::disk($disk)->delete($konten->file_path);
                }
                // Upload new file
                $file = $request->file('file_konten');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('', $fileName, $disk);
                $data['file_path'] = $fileName;
            } else {
                // If no new file is uploaded, retain the old file_path if the type is still file/gambar
                // If tipe changed from link to file/gambar without upload, file_path might be null.
                // If file_path was already set and tipe didn't change, keep it.
                if ($konten->tipe !== 'link' && $konten->file_path) {
                    $data['file_path'] = $konten->file_path;
                } else {
                    $data['file_path'] = null; // Reset if it was a link or no file existed
                }
            }
        }

        $konten->update($data);

        // Adjust route for admin context if necessary
        return redirect()->route('konten.index')->with('success', 'Konten berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $konten = Konten::findOrFail($id);
        $disk = 'konten';

        // Delete the associated file if it exists
        if ($konten->file_path && Storage::disk($disk)->exists($konten->file_path)) {
            Storage::disk($disk)->delete($konten->file_path);
        }

        $konten->delete();

        // Adjust route for admin context if necessary
        return redirect()->route('konten.index')->with('success', 'Konten berhasil dihapus.');
    }
}

