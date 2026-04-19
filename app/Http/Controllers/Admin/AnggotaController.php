<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $anggota = User::where('role', 'anggota')
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('admin.anggota.index', compact('anggota'));
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
            'alamat' => 'required|string',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'anggota';
        $data['status'] = 'aktif';

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
}
