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
        $data = [
            'totalAlumni' => User::where('role', 'alumni')->count(),
            'newAlumniThisMonth' => User::where('role', 'alumni')
                ->whereMonth('created_at', now()->month)
                ->count(),
            'pendingApprovals' => User::where('approved', false)
                ->where('email_verified_at', '!=', null)
                ->count(),
            'activePrograms' => ProgramKerja::where('status', 'in_progress')->count(),
            'completedProgramsThisMonth' => ProgramKerja::where('status', 'completed')
                ->whereMonth('updated_at', now()->month)
                ->count(),
            'upcomingEvents' => Event::where('event_date', '>', now())->count(),
            'eventsThisWeek' => Event::whereBetween('event_date', [now(), now()->addWeek()])->count(),

            // Get recent activities (events, program updates, payments)
            'recentActivities' => collect(), // Will implement activity logging later

            // Get ongoing program progress
            'programProgress' => ProgramKerja::where('status', 'in_progress')
                ->select('name', 'progress_percentage as progress')
                ->orderBy('progress_percentage', 'desc')
                ->take(5)
                ->get(),

            // Get upcoming events 
            'upcomingEventsList' => Event::where('event_date', '>', now())
                ->orderBy('event_date', 'asc')
                ->take(5)
                ->get()
                ->map(function($event) {
                    $event->status_color = $this->getStatusColor($event);
                    return $event;
                }),
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * Get the color for event status based on date.
     */
    private function getStatusColor($event): string
    {
        $today = now();
        $eventDate = $event->event_date;
        
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
