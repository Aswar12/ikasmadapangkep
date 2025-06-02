<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Payment;
use App\Models\ProgramKerja;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        // Get dashboard statistics
        $stats = [
            'total_alumni' => User::where('role', 'alumni')->count(),
            'alumni_aktif' => User::where('role', 'alumni')->where('status', 'approved')->count(),
            'alumni_pending' => User::where('role', 'alumni')->where('status', 'pending')->count(),
            'new_alumni_this_month' => User::where('role', 'alumni')
                ->whereMonth('created_at', now()->month)
                ->count(),
            'pending_approvals' => User::where('status', 'pending')
                ->where('email_verified_at', '!=', null)
                ->count(),
            'program_kerja_aktif' => ProgramKerja::where('status', 'ongoing')->count(),
            'completed_programs_this_month' => ProgramKerja::where('status', 'completed')
                ->whereMonth('updated_at', now()->month)
                ->count(),
            'upcoming_events' => Event::where('start_date', '>', now())->count(),
            'events_this_week' => Event::whereBetween('start_date', [now(), now()->addWeek()])->count(),
        ];

        $pendingApprovals = User::where('status', 'pending')
            ->where('email_verified_at', '!=', null)
            ->get();

        // Get recent activities (events, program updates, payments)
        $recentActivities = collect(); // Will implement activity logging later

        // Get ongoing program progress
        $programProgress = ProgramKerja::where('status', 'ongoing')
            ->select('name', 'progress')
            ->orderBy('progress', 'desc')
            ->take(5)
            ->get();

        // Get upcoming events 
        $upcomingEventsList = Event::where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get()
            ->map(function($event) {
                $event->status_color = $this->getStatusColor($event);
                return $event;
            });

        // Get department statistics
        $departmentStats = \App\Models\Department::withCount('programKerja')
            ->withCount(['programKerja as active_programs_count' => function ($query) {
                $query->where('status', 'ongoing');
            }])
            ->get();

        // Alumni grouped by graduation year
        $alumniByYear = \App\Models\Profile::selectRaw('graduation_year, count(*) as total')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->where('users.role', 'alumni')
            ->groupBy('graduation_year')
            ->orderBy('graduation_year')
            ->get();

        // Alumni grouped by current job
        $alumniByJob = \App\Models\Profile::selectRaw('current_job, count(*) as total')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->where('users.role', 'alumni')
            ->groupBy('current_job')
            ->orderBy('total', 'desc')
            ->get();

        return view('dashboard.admin', compact('stats', 'pendingApprovals', 'recentActivities', 'programProgress', 'upcomingEventsList', 'departmentStats', 'alumniByYear', 'alumniByJob'));
    }

    /**
     * Get the color for event status based on date.
     */
    private function getStatusColor($event): string
    {
        $today = now();
        $eventDate = $event->start_date;
        
        if ($eventDate->isPast()) {
            return 'gray';
        }
        
        if ($eventDate->diffInDays($today) <= 7) {
            return 'yellow';  // Event dalam 7 hari
        }
        
        if ($eventDate->diffInDays($today) <= 30) {
            return 'green';   // Event dalam 30 hari
        }
        
        return 'blue';       // Event masih lama
    }
}
