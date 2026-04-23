<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        if ($user->role === 'anggota' && $user->status === 'tidak_aktif') {
            return back()->withErrors(['email' => 'Akun Anda sudah tidak aktif.'])->withInput();
        }

        Auth::login($user, $request->has('remember'));

        $request->session()->regenerate();

        if (in_array($user->role, ['admin', 'sekretaris', 'ketua'])) {
            return redirect('/admin/dashboard')->with('success', 'Selamat datang, '.$user->name.'!');
        }

        return redirect('/anggota/dashboard')->with('success', 'Selamat datang, '.$user->name.'!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }

    public function showLupaPassword()
    {
        return view('auth.lupa-password');
    }

    public function lupaPassword(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])->withInput();
        }

        $request->session()->put('reset_email', $request->email);

        return redirect()->route('password.reset');
    }

    public function showResetPassword()
    {
        $email = session('reset_email');

        if (! $email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Silakan masukkan email terlebih dahulu.']);
        }

        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $email = session('reset_email');

        if (! $email) {
            return back()->withErrors(['email' => 'Sesi reset password tidak valid.']);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $request->session()->forget('reset_email');

        return redirect('/login')->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }
}
