<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiInvite;
use App\Models\AbsensiSesi;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class AbsensiController extends Controller
{
    /**
     * Display a listing of kegiatan for attendance management.
     */
    public function index()
    {
        $kegiatans = Kegiatan::all();
        return view('admin.absensi.index', compact('kegiatans'));
    }

    /**
     * Display form to invite members for a specific kegiatan.
     */
    public function invite(Kegiatan $kegiatan)
    {
        // Fetch all users who are not yet invited to this kegiatan
        $invitedUserIds = AbsensiInvite::where('kegiatan_id', $kegiatan->id)->pluck('user_id');
        $members = User::whereNotIn('id', $invitedUserIds)->get();

        return view('admin.absensi.invite', compact('kegiatan', 'members'));
    }

    /**
     * Store invited members for a specific kegiatan.
     */
    public function storeInvite(Request $request, Kegiatan $kegiatan)
    {
        $validator = Validator::make($request->all(), [
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        foreach ($request->member_ids as $userId) {
            AbsensiInvite::create([
                'kegiatan_id' => $kegiatan->id,
                'user_id' => $userId,
            ]);
        }

        return redirect()->route('admin.absensi.index')->with('success', 'Members invited successfully.');
    }

    /**
     * Display form to manage attendance sessions for a specific kegiatan.
     */
    public function sesi(Kegiatan $kegiatan)
    {
        $sessions = AbsensiSesi::where('kegiatan_id', $kegiatan->id)->with('absensi')->get();
        // Use the model's isSessionActive() method for clarity
        $activeSession = $sessions->firstWhere(function ($session) {
            return $session->isSessionActive();
        });
        
        // Fetch users who are invited and not yet in any session for this kegiatan
        $invitedUserIds = AbsensiInvite::where('kegiatan_id', $kegiatan->id)->pluck('user_id');
        // Collect all user IDs that have attended any session for this specific kegiatan
        $attendedUserIds = Absensi::whereIn('absensi_sesi_id', $sessions->pluck('id'))->pluck('user_id')->unique();
        
        $availableMembers = User::whereIn('id', $invitedUserIds)
                                ->whereNotIn('id', $attendedUserIds)
                                ->get();

        return view('admin.absensi.sesi', compact('kegiatan', 'sessions', 'activeSession', 'availableMembers'));
    }

    /**
     * Starts an attendance session for a kegiatan.
     */
    public function mulaiSesi(Kegiatan $kegiatan, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required|in:mandiri,qr_code',
            'start_time' => 'nullable|date_format:H:i',
            'start_date' => 'nullable|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Use the model's isSessionActive() method for clarity
        $activeSession = AbsensiSesi::where('kegiatan_id', $kegiatan->id)->get()->firstWhere(function ($session) {
            return $session->isSessionActive();
        });

        if ($activeSession) {
            return back()->with('warning', 'A session is already active for this event.');
        }

        $session = new AbsensiSesi();
        $session->kegiatan_id = $kegiatan->id;
        $session->metode = $request->method; // Correctly map to model attribute 'metode'
        $session->tipe_sesi = $request->method; // Assuming tipe_sesi should also be set or is redundant

        if ($request->filled('start_date') && $request->filled('start_time')) {
            // Correctly use the model's column name for start time
            $session->dimulai_at = $request->start_date . ' ' . $request->start_time;
        } else {
            // Correctly use the model's column name for start time
            $session->dimulai_at = now();
        }

        if ($request->method === 'qr_code') {
            // Use the static method from the model
            $session->qr_token = AbsensiSesi::generateQrToken(); 
            // Optional: Set QR expiry, e.g., 1 hour from now
            $session->qr_expires_at = now()->addHour(); 
        }
        
        // Assuming the authenticated user is the one starting the session
        // This requires authentication middleware to be active for the admin routes
        if (auth()->check()) {
            $session->dimulai_oleh = auth()->id();
        }
        
        $session->save();

        return redirect()->route('admin.absensi.sesi', $kegiatan->id)->with('success', 'Attendance session started successfully.');
    }

    /**
     * Ends an active attendance session for a kegiatan.
     */
    public function akhiriSesi(Kegiatan $kegiatan, Request $request)
    {
        // Use the model's isSessionActive() method for clarity
        $activeSession = AbsensiSesi::where('kegiatan_id', $kegiatan->id)->get()->firstWhere(function ($session) {
            return $session->isSessionActive();
        });

        if (!$activeSession) {
            return back()->with('warning', 'No active session found to end.');
        }

        // Correctly use the model's column name for end time
        $activeSession->diselesaikan_at = now();
        // Assuming the authenticated user is the one ending the session
        if (auth()->check()) {
            $activeSession->diselesaikan_oleh = auth()->id();
        }
        $activeSession->save();

        return redirect()->route('admin.absensi.sesi', $kegiatan->id)->with('success', 'Attendance session ended successfully.');
    }

    /**
     * Displays the QR code interface for an active QR session.
     * Note: Actual scanning is client-side, this view will display the QR code to be scanned.
     */
    public function qr(Kegiatan $kegiatan)
    {
        // Use the model's isSessionActive() method for clarity and check method
        $activeSession = AbsensiSesi::where('kegiatan_id', $kegiatan->id)
                                    ->where('metode', 'qr_code') // Ensure it's a QR code session
                                    ->get()
                                    ->firstWhere(function ($session) {
                                        return $session->isSessionActive();
                                    });

        if (!$activeSession || !$activeSession->qr_token) {
            return redirect()->route('admin.absensi.sesi', $kegiatan->id)->with('warning', 'No active QR session found for this event or QR token is missing.');
        }

        // Generate QR code SVG using the token
        $qrCodeSvg = QrCode::format('svg')->size(200)->generate($activeSession->qr_token);

        return view('admin.absensi.qr-scanner', compact('kegiatan', 'qrCodeSvg', 'activeSession'));
    }

    /**
     * Processes scanned QR codes from members.
     * This method would typically be called by a client-side scanner.
     */
    public function scan(Kegiatan $kegiatan, Request $request)
    {
        // Combined validator for token and user_id
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'user_id' => 'required|exists:users,id', // Assuming user_id is sent by the scanner app
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $userId = $request->user_id; // Use the provided user_id

        // Find the active session matching the QR token for this kegiatan
        // Use the model's isSessionActive() method for clarity
        $session = AbsensiSesi::where('kegiatan_id', $kegiatan->id)
                                ->where('qr_token', $request->token)
                                ->get()
                                ->firstWhere(function ($s) {
                                    return $s->isSessionActive();
                                });

        if (!$session) {
            return response()->json(['message' => 'Invalid or expired QR code session.'], 400);
        }

        // Check if the user has already attended this specific session
        $existingAbsensi = Absensi::where('absensi_sesi_id', $session->id)
                                    ->where('user_id', $userId)
                                    ->first();

        if ($existingAbsensi) {
            return response()->json(['message' => 'You have already marked your attendance for this session.'], 409); // 409 Conflict
        }

        // Create the attendance record
        Absensi::create([
            'absensi_sesi_id' => $session->id,
            'user_id' => $userId,
            'attended_at' => now(),
            'status' => 'present', // Default status
        ]);

        return response()->json(['message' => 'Attendance marked successfully.'], 200);
    }

    /**
     * Displays attendance recap for a specific kegiatan.
     */
    public function rekap(Kegiatan $kegiatan)
    {
        // Fetch all sessions for the kegiatan, eager loading their absensi records
        $sessions = AbsensiSesi::where('kegiatan_id', $kegiatan->id)->with('absensi')->get();
        
        // Aggregate attendance data preparation
        $attendanceData = [];
        
        // Get all user IDs that were invited to this kegiatan
        $invitedUserIds = AbsensiInvite::where('kegiatan_id', $kegiatan->id)->pluck('user_id');
        
        // Fetch User models for all invited users
        $users = User::whereIn('id', $invitedUserIds)->get();

        // Structure the attendance data for the view
        foreach ($users as $user) {
            $userAttendance = [];
            // Iterate through each session to find the user's attendance status
            foreach ($sessions as $session) {
                // Find the specific attendance record for this user in this session
                $absensi = $session->absensi->where('user_id', $user->id)->first();
                
                $userAttendance[$session->id] = [
                    // Format session name for display, handle cases where started_at might be null (though unlikely if session is in $sessions)
                    'session_name' => ($session->dimulai_at ? $session->dimulai_at->format('Y-m-d H:i') : 'N/A') . 
                                      ($session->diselesaikan_at ? ' - ' . $session->diselesaikan_at->format('H:i') : ($session->dimulai_at ? ' (Active)' : '')),
                    'status' => $absensi ? $absensi->status : 'absent',
                    'attended_at' => $absensi ? $absensi->attended_at : null,
                ];
            }
            // Store attendance data keyed by user ID
            $attendanceData[$user->id] = [
                'name' => $user->name,
                'email' => $user->email,
                'sessions' => $userAttendance,
            ];
        }

        // Pass data to the view
        return view('admin.absensi.rekap', compact('kegiatan', 'sessions', 'attendanceData', 'users'));
    }
}
