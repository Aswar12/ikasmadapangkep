<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\ProgramKerja;
use App\Models\Profile;
use App\Models\Payment;
use App\Models\Album;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumniDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Profile completion status
        $profile = Profile::where('user_id', $user->id)->first();
        $profileCompletion = $this->calculateProfileCompletion($profile);
        
        // Payment status
        $currentYear = date('Y');
        $paymentStatus = Payment::where('user_id', $user->id)
            ->where('year_period', $currentYear)
            ->first();
        
        // Upcoming events
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();
        
        // My registered events
        $myEvents = Event::whereHas('registrations', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('event_date', '>=', now())
        ->orderBy('event_date', 'asc')
        ->get();
        
        // Latest program kerja
        $latestPrograms = ProgramKerja::with('department')
            ->where('status', 'in_progress')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
        
        // Latest job vacancies
        $latestJobs = JobVacancy::where('is_active', true)
            ->where('application_deadline', '>=', now())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Latest albums from my year
        $latestAlbums = Album::where('graduation_year', $user->graduation_year)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        // Statistics
        $stats = [
            'total_alumni_angkatan' => \App\Models\User::where('graduation_year', $user->graduation_year)
                ->where('role', 'alumni')
                ->count(),
            'total_events_registered' => $user->eventRegistrations()->count(),
            'profile_completion' => $profileCompletion,
            'payment_status' => $paymentStatus ? $paymentStatus->status : 'belum_bayar',
        ];
        
        return view('alumni.dashboard.index', [
            'user' => $user,
            'profile' => $profile,
            'profileCompletion' => $profileCompletion,
            'paymentStatus' => $paymentStatus,
            'upcomingEvents' => $upcomingEvents ?? null
        ]);
    }
    
    private function calculateProfileCompletion($profile)
    {
        if (!$profile) {
            return 0;
        }
        
        $fields = [
            'gender', 'birth_place', 'birth_date', 'national_student_number',
            'address', 'phone_number', 'father_name', 'mother_name',
            'entry_year', 'graduation_year', 'diploma_number', 'profile_photo'
        ];
        
        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($profile->$field)) {
                $filled++;
            }
        }
        
        return round(($filled / count($fields)) * 100);
    }
}
