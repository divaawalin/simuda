<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        $token = Str::random(64);

        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        $resetLink = url('/reset-password/'.$token);

        return redirect('/reset-password/'.$token)->with('info', 'Link reset password: '.$resetLink);
    }

    public function showResetPassword($token)
    {
        $tokenData = \DB::table('password_reset_tokens')
            ->where('token', 'like', '%'.substr($token, 0, 16).'%')
            ->first();

        return view('auth.reset-password', compact('token'));
    }

    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'password_baru' => 'required|min:8',
            'konfirmasi_password' => 'required|same:password_baru',
        ], [
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password minimal 8 karakter.',
            'konfirmasi_password.required' => 'Konfirmasi password wajib diisi.',
            'konfirmasi_password.same' => 'Password tidak sama.',
        ]);

        $email = $request->email ?? null;

        if (! $email) {
            return back()->withErrors(['token' => 'Link reset password tidak valid.']);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        \DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect('/login')->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }
}
