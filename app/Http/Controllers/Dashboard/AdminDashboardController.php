<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\ProgramKerja;
use App\Models\Department;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $stats = [
            'total_alumni' => User::where('role', 'alumni')->count(),
            'alumni_aktif' => User::where('role', 'alumni')->where('status', 'active')->count(),
            'alumni_pending' => User::where('role', 'alumni')->where('status', 'pending')->count(),
            'total_departments' => Department::count(),
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('event_date', '>=', now())->count(),
            'total_program_kerja' => ProgramKerja::count(),
            'program_kerja_aktif' => ProgramKerja::where('status', 'in_progress')->count(),
        ];

        // Alumni berdasarkan tahun kelulusan
        $alumniByYear = DB::table('users')
            ->where('users.role', 'alumni')
            ->whereNotNull('users.angkatan')
            ->select('users.angkatan as graduation_year', DB::raw('count(*) as total'))
            ->groupBy('users.angkatan')
            ->orderBy('users.angkatan', 'desc')
            ->take(10)
            ->get();

        // Alumni berdasarkan pekerjaan
        $alumniByJob = DB::table('users')
            ->where('users.role', 'alumni')
            ->whereNotNull('users.current_job')
            ->select('users.current_job', DB::raw('count(*) as total'))
            ->groupBy('users.current_job')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        // Pending approvals
        $pendingApprovals = User::where('role', 'alumni')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Recent registrations
        $recentRegistrations = User::where('role', 'alumni')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Login attempts (failed) - check if table exists
        $recentFailedLogins = collect();
        if (DB::getSchemaBuilder()->hasTable('login_attempts')) {
            $recentFailedLogins = LoginAttempt::where('success', false)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        }

        // Program kerja progress
        $programKerjaProgress = ProgramKerja::with('department')
            ->where('status', 'in_progress')
            ->orderBy('progress_percentage', 'desc')
            ->take(5)
            ->get();

        // Department statistics
        $departmentStats = Department::withCount([
            'programKerja',
            'programKerja as active_programs_count' => function ($query) {
                $query->where('status', 'in_progress');
            }
        ])->get();

        return view('dashboard.admin', [
            'stats' => $stats,
            'alumniByYear' => $alumniByYear,
            'alumniByJob' => $alumniByJob,
            'pendingApprovals' => $pendingApprovals,
            'recentRegistrations' => $recentRegistrations,
            'recentFailedLogins' => $recentFailedLogins,
            'programKerjaProgress' => $programKerjaProgress,
            'departmentStats' => $departmentStats
        ]);
    }
}
