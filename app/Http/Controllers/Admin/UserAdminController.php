<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'sekretaris', 'ketua'])->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|in:admin,sekretaris,ketua',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('profiles'), $fileName);
            $data['foto_profile'] = $fileName;
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User Admin berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::whereIn('role', ['admin', 'sekretaris', 'ketua'])->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::whereIn('role', ['admin', 'sekretaris', 'ketua'])->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'alamat' => 'required|string',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|in:admin,sekretaris,ketua',
        ]);

        $data = $request->except(['password', 'foto_profile']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_profile')) {
            if ($user->foto_profile && File::exists(storage_path('profiles/' . $user->foto_profile))) {
                File::delete(storage_path('profiles/' . $user->foto_profile));
            }
            $file = $request->file('foto_profile');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('profiles'), $fileName);
            $data['foto_profile'] = $fileName;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::whereIn('role', ['admin', 'sekretaris', 'ketua'])->findOrFail($id);
        
        if ($user->foto_profile && File::exists(storage_path('profiles/' . $user->foto_profile))) {
            File::delete(storage_path('profiles/' . $user->foto_profile));
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User Admin berhasil dihapus.');
    }
}
