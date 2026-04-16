<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the profile page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('anggota.profile.index', compact('user'));
    }

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        return view('anggota.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'divisi' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto_profile' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $user->name = $request->name;
        $user->divisi = $request->divisi;
        $user->no_telp = $request->no_telp;
        $user->alamat = $request->alamat;

        if ($request->hasFile('foto_profile')) {
            // Delete old profile picture if it exists
            if ($user->foto_profile) {
                Storage::disk('profiles')->delete($user->foto_profile);
            }
            // Upload new profile picture
            $path = $request->file('foto_profile')->store('uploads', 'profiles'); // Store in 'uploads' subdirectory of 'profiles' disk
            $user->foto_profile = $path;
        }

        $user->save();

        return redirect()->route('anggota.profile.index')->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('anggota.profile.index')->with('success', 'Password updated successfully.');
    }
}
