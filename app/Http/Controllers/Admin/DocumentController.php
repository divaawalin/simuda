<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('uploadedBy')->latest()->paginate(10);

        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(StoreDocumentRequest $request)
    {
        $uploadedFile = $request->file('file');
        
        $fileSize = $uploadedFile->getSize();
        $fileMime = $uploadedFile->getClientMimeType();
        
        File::ensureDirectoryExists(storage_path('dokumen'));
        $fileName = time().'_'.uniqid().'.'.$uploadedFile->getClientOriginalExtension();
        $uploadedFile->move(storage_path('dokumen'), $fileName);

        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $fileName,
            'file_type' => $fileMime,
            'file_size' => $fileSize,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function show(Document $document)
    {
        $path = storage_path('dokumen/' . $document->file_path);
        if (! File::exists($path)) {
            abort(404);
        }
        return response()->download($path, $document->title . '.' . \File::extension($document->file_path));
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(StoreDocumentRequest $request, Document $document)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        $uploadedFile = $request->file('file');

        if ($uploadedFile) {
            $fileSize = $uploadedFile->getSize();
            $fileMime = $uploadedFile->getClientMimeType();

            if ($document->file_path && File::exists(storage_path('dokumen/'.$document->file_path))) {
                File::delete(storage_path('dokumen/'.$document->file_path));
            }
            File::ensureDirectoryExists(storage_path('dokumen'));
            $fileName = time().'_'.uniqid().'.'.$uploadedFile->getClientOriginalExtension();
            $uploadedFile->move(storage_path('dokumen'), $fileName);
            $data['file_path'] = $fileName;
            $data['file_type'] = $fileMime;
            $data['file_size'] = $fileSize;
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path && File::exists(storage_path('dokumen/'.$document->file_path))) {
            File::delete(storage_path('dokumen/'.$document->file_path));
        }

        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
