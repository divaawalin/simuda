<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiInvite;
use App\Models\AbsensiSesi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AbsensiController extends Controller
{
    /**
     * Display list of Kegiatan the logged-in member is invited to.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            // Should not happen with 'auth' middleware, but good practice
            abort(401, 'Unauthenticated.');
        }

        // Get IDs of kegiatan the user is invited to
        $invitedKegiatanIds = AbsensiInvite::where('user_id', $user->id)->pluck('kegiatan_id');

        // Fetch the actual kegiatan objects
        $kegiatans = Kegiatan::whereIn('id', $invitedKegiatanIds)->get();

        return view('anggota.absensi.index', compact('kegiatans'));
    }

    /**
     * Show session details for a given Kegiatan, allowing attendance submission.
     */
    public function detail(Kegiatan $kegiatan)
    {
        $user = Auth::user();
        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        // Verify if the logged-in user is invited to this Kegiatan
        $isInvited = $user->absensiInvites()->where('kegiatan_id', $kegiatan->id)->exists();
        if (!$isInvited) {
            abort(403, 'You are not invited to this activity.');
        }

        // Fetch active and upcoming sessions for the given kegiatan
        // Assuming 'sesis()' is a relationship method in the Kegiatan model
        $sesis = $kegiatan->sesis()
                         ->whereIn('type', ['mulai', 'selesai'])
                         ->orderBy('started_at') // Order by start time to show them logically
                         ->get();

        return view('anggota.absensi.detail', compact('kegiatan', 'sesis', 'user'));
    }

    /**
     * Display the member's personal QR code for scanning by admin.
     */
    public function qr(Kegiatan $kegiatan)
    {
        $user = Auth::user();
        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        // Verify if the logged-in user is invited to this Kegiatan
        $isInvited = $user->absensiInvites()->where('kegiatan_id', $kegiatan->id)->exists();
        if (!$isInvited) {
            abort(403, 'You are not invited to this activity.');
        }

        // Data to be encoded in QR code: user ID and kegiatan ID
        // This QR code is for the admin to scan the member
        $qrData = json_encode([
            'user_id' => $user->id,
            'kegiatan_id' => $kegiatan->id,
            // Optionally include a specific session ID if needed for a direct scan submission,
            // but typically the admin interface would choose the session.
            // For now, let's keep it general for the member to show.
        ]);

        return view('anggota.absensi.qr', compact('qrData', 'kegiatan', 'user'));
    }

    /**
     * Submit attendance for mulai or selesai session.
     * Handles both 'mandiri' (self-submission) and 'qr_code' (admin scan) methods.
     */
    public function absen(Kegiatan $kegiatan, Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        // Verify if the logged-in user is invited to this Kegiatan
        // This check is for 'mandiri' submissions. For 'qr_code', we verify the scanned user.
        $isInvited = $user->absensiInvites()->where('kegiatan_id', $kegiatan->id)->exists();
        if (!$isInvited && $request->input('method') === 'mandiri') {
            abort(403, 'You are not invited to this activity.');
        }

        $method = $request->input('method');
        $sessionId = $request->input('session_id');
        $submittedUserId = $user->id; // Default to logged-in user for mandiri

        if ($method === 'qr_code') {
            // For QR code method, user_id and session_id are submitted by admin's scanner
            $submittedUserId = $request->input('user_id');
            $sessionId = $request->input('session_id');
            
            if (!$submittedUserId || !$sessionId) {
                return back()->withErrors(['qr_scan' => 'Invalid QR code data. Please try again.']);
            }

            // Verify if the scanned user is invited to this Kegiatan
            $scannedUser = \App\Models\User::find($submittedUserId);
            if (!$scannedUser || !$scannedUser->absensiInvites()->where('kegiatan_id', $kegiatan->id)->exists()) {
                return back()->withErrors(['qr_scan' => 'The scanned user is not invited to this activity.']);
            }
        } elseif ($method !== 'mandiri' || !$sessionId) {
            return back()->withErrors(['submission' => 'Invalid submission data. Please select a session and method.']);
        }

        // Find the specific session
        $sesi = AbsensiSesi::where('id', $sessionId)
                           ->where('kegiatan_id', $kegiatan->id)
                           ->first();

        if (!$sesi) {
            return back()->withErrors(['session' => 'Session not found for this activity.']);
        }

        // Check if the session has started
        // For 'mulai', it needs to have started. For 'selesai', it also needs to have started.
        // The prompt implies sessions should be available if admin started them.
        // We assume 'started_at' is the key indicator that a session is active.
        if (!$sesi->started_at || now() < $sesi->started_at) {
             return back()->withErrors(['session' => 'This session has not started yet.']);
        }

        // Check if attendance is already recorded for this user and session
        $existingAttendance = Absensi::where('user_id', $submittedUserId)
                                     ->where('absensi_sesi_id', $sessionId)
                                     ->first();

        if ($existingAttendance) {
            return back()->withErrors(['attendance' => 'Attendance already recorded for this session.']);
        }

        // Record attendance
        try {
            Absensi::create([
                'user_id' => $submittedUserId,
                'kegiatan_id' => $kegiatan->id,
                'absensi_sesi_id' => $sessionId,
                'method' => $method,
                'timestamp' => now(),
            ]);

            return back()->with('success', 'Attendance recorded successfully!');

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error("Attendance submission failed: " . $e->getMessage(), [
                'user_id' => $submittedUserId,
                'kegiatan_id' => $kegiatan->id,
                'absensi_sesi_id' => $sessionId,
                'method' => $method,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'An error occurred while recording attendance. Please try again later.']);
        }
    }
}
