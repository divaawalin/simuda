<?php

namespace App\Services;

use App\Models\Absensi;
use App\Models\AbsensiInvite;
use App\Models\AbsensiSesi;
use App\Models\Kegiatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AttendanceService
{
    /**
     * Calculate attendance percentage for a specific user in a given activity.
     *
     * @param User $user
     * @param Kegiatan $kegiatan
     * @return float
     */
    public function calculateUserActivityAttendancePercentage(User $user, Kegiatan $kegiatan): float
    {
        // Check if the user was invited to the activity
        $isInvited = AbsensiInvite::where('user_id', $user->id)
                                  ->where('kegiatan_id', $kegiatan->id)
                                  ->exists();

        if (!$isInvited) {
            return 0.0; // User was not invited, so 0% attendance
        }

        // Get all completed attendance sessions for the activity
        $completedSessions = AbsensiSesi::where('kegiatan_id', $kegiatan->id)
                                        ->where('status_sesi', 'selesai')
                                        ->count();

        if ($completedSessions === 0) {
            return 0.0; // No completed sessions, cannot calculate percentage
        }

        // Count how many times the user attended (status = 'hadir') in these sessions
        $attendedCount = Absensi::where('user_id', $user->id)
                                ->where('kegiatan_id', $kegiatan->id)
                                ->whereHas('sesi', function ($query) {
                                    $query->where('status_sesi', 'selesai');
                                })
                                ->where('status', 'hadir')
                                ->count();

        return ($attendedCount / $completedSessions) * 100;
    }

    /**
     * Get yearly/monthly attendance recap for a specific user.
     *
     * @param User $user
     * @param int|null $year
     * @param int|null $month
     * @return array
     */
    public function getUserRecap(User $user, ?int $year = null, ?int $month = null): array
    {
        $year = $year ?? Carbon::now()->year;

        $query = AbsensiInvite::where('user_id', $user->id)
                              ->whereYear('created_at', $year); // Assuming invites are created around activity time

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        $invitedKegiatanIds = $query->pluck('kegiatan_id');

        $totalInvitedActivities = $invitedKegiatanIds->count();
        $totalAttendedSessions = 0;
        $totalPossibleSessions = 0;

        foreach ($invitedKegiatanIds as $kegiatanId) {
            $kegiatan = Kegiatan::find($kegiatanId);
            if (!$kegiatan) continue;

            $completedSessionsForKegiatan = AbsensiSesi::where('kegiatan_id', $kegiatan->id)
                                                        ->where('status_sesi', 'selesai')
                                                        ->count();

            $attendedSessionsForKegiatan = Absensi::where('user_id', $user->id)
                                                ->where('kegiatan_id', $kegiatan->id)
                                                ->whereHas('sesi', function ($q) {
                                                    $q->where('status_sesi', 'selesai');
                                                })
                                                ->where('status', 'hadir')
                                                ->count();
            
            $totalAttendedSessions += $attendedSessionsForKegiatan;
            $totalPossibleSessions += $completedSessionsForKegiatan;
        }

        $overallPercentage = ($totalPossibleSessions > 0) ? ($totalAttendedSessions / $totalPossibleSessions) * 100 : 0.0;

        return [
            'total_invited_activities' => $totalInvitedActivities,
            'total_attended_sessions' => $totalAttendedSessions,
            'total_possible_sessions' => $totalPossibleSessions,
            'overall_attendance_percentage' => round($overallPercentage, 2),
            'year' => $year,
            'month' => $month,
        ];
    }
}
