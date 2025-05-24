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
            'total_departments' => Department::count(),
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('event_date', '>=', now())->count(),
            'total_program_kerja' => ProgramKerja::count(),
            'program_kerja_aktif' => ProgramKerja::where('status', 'in_progress')->count(),
        ];

        // Alumni berdasarkan tahun kelulusan
        $alumniByYear = DB::table('users')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->join('year_references', 'profiles.graduation_year_id', '=', 'year_references.id')
            ->where('users.role', 'alumni')
            ->select('year_references.year', DB::raw('count(*) as total'))
            ->groupBy('year_references.year', 'year_references.id')
            ->orderBy('year_references.year', 'desc')
            ->take(10)
            ->get();

        // Alumni berdasarkan pekerjaan
        $alumniByJob = DB::table('users')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->join('profession_references', 'profiles.profession_id', '=', 'profession_references.id')
            ->where('users.role', 'alumni')
            ->whereNotNull('profiles.profession_id')
            ->select('profession_references.name as profession', DB::raw('count(*) as total'))
            ->groupBy('profession_references.name', 'profession_references.id')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        // Recent registrations
        $recentRegistrations = User::where('role', 'alumni')
            ->with('profile.yearReference', 'profile.professionReference')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Login attempts (failed)
        $recentFailedLogins = LoginAttempt::where('success', false)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Program kerja progress
        $programKerjaProgress = ProgramKerja::with('department')
            ->where('status', 'in_progress')
            ->orderBy('progress_percentage', 'desc')
            ->take(5)
            ->get();

        // Department statistics
        $departmentStats = Department::withCount([
            'programKerja',
            'programKerja as active_programs' => function ($query) {
                $query->where('status', 'in_progress');
            }
        ])->get();

        return view('admin.dashboard.index', [
            'stats' => $stats,
            'alumniByYear' => $alumniByYear,
            'alumniByJob' => $alumniByJob,
            'recentRegistrations' => $recentRegistrations,
            'recentFailedLogins' => $recentFailedLogins,
            'programKerjaProgress' => $programKerjaProgress,
            'departmentStats' => $departmentStats
        ]);
    }
}
