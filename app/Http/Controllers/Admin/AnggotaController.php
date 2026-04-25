<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'anggota');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('divisi', 'like', "%{$search}%")
                    ->orWhere('desa', 'like', "%{$search}%")
                    ->orWhere('kelompok', 'like', "%{$search}%")
                    ->orWhere('jenis_kelamin', 'like', "%{$search}%");
            });
        }

        $anggota = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        // Gender statistics (using jenis_kelamin column)
        $totalAnggota = User::where('role', 'anggota')->count();
        $maleCount = User::where('role', 'anggota')->where('jenis_kelamin', 'L')->count();
        $femaleCount = User::where('role', 'anggota')->where('jenis_kelamin', 'P')->count();
        $malePercent = $totalAnggota > 0 ? round(($maleCount / $totalAnggota) * 100, 1) : 0;
        $femalePercent = $totalAnggota > 0 ? round(($femaleCount / $totalAnggota) * 100, 1) : 0;

        return view('admin.anggota.index', compact('anggota', 'maleCount', 'femaleCount', 'malePercent', 'femalePercent', 'totalAnggota'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'alamat' => 'nullable|string',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'desa' => 'nullable|string|max:255',
            'kelompok' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'status' => 'nullable|in:aktif,tidak_aktif',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'anggota';
        $data['status'] = $request->status ?? 'aktif';

        // Only set foto_profile if new file uploaded
        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(storage_path('profiles'), $fileName);
            $data['foto_profile'] = $fileName;
        }

        User::create($data);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $anggota = User::findOrFail($id);

        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,'.$anggota->id,
            'password' => 'nullable|string|min:8',
            'alamat' => 'required|string',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['password']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama jika ada
            if ($anggota->foto_profile && File::exists(storage_path('profiles/'.$anggota->foto_profile))) {
                File::delete(storage_path('profiles/'.$anggota->foto_profile));
            }
            $file = $request->file('foto_profile');
            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(storage_path('profiles'), $fileName);
            $data['foto_profile'] = $fileName;
        }

        $anggota->update($data);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $anggota = User::findOrFail($id);

        // Hapus foto profile jika ada
        if ($anggota->foto_profile && File::exists(storage_path('profiles/'.$anggota->foto_profile))) {
            File::delete(storage_path('profiles/'.$anggota->foto_profile));
        }

        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $anggota = User::findOrFail($id);
        $anggota->status = $anggota->status === 'aktif' ? 'tidak_aktif' : 'aktif';
        $anggota->save();

        return redirect()->route('anggota.index')->with('success', 'Status anggota berhasil diubah.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new AnggotaImport, $request->file('file'));

            return redirect()->route('anggota.index')->with('success', 'Import data anggota berhasil.');
        } catch (\Exception $e) {
            return redirect()->route('anggota.index')->with('error', 'Gagal import: '.$e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['nama', 'email', 'no_hp', 'divisi', 'status'];
        foreach ($headers as $index => $header) {
            $sheet->setCellValueByColumnAndRow($index + 1, 1, $header);
        }

        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'template_anggota_').'.xlsx';
        $writer->save($tempFile);

        return response()->download($tempFile, 'template_anggota.xlsx')->deleteFileAfterSend(true);
    }
}
