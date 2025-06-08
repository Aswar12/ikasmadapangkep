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
            ->where('year', $currentYear)
            ->first();
        
        // Upcoming events
        $upcomingEvents = Event::where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();
            
        // Untuk kompatibilitas dengan template
        $upcoming_events = $upcomingEvents;
        
        // My registered events
        $myEvents = Event::whereHas('registrations', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('start_date', '>=', now())
        ->orderBy('start_date', 'asc')
        ->get();
        
        // Latest program kerja
        $latestPrograms = ProgramKerja::with('department')
            ->where('status', 'in_progress')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
        
        // Latest job vacancies
        $latestJobs = JobVacancy::where('status', 'published')
            ->where('deadline', '>=', now())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Untuk kompatibilitas dengan template
        $recent_jobs = $latestJobs;
        
        // Latest albums from my year
        $latestAlbums = Album::where('angkatan', $user->angkatan)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        // Statistics
        $statusTranslations = [
            'waiting_verification' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            'pending' => 'Belum Bayar',
            'belum bayar' => 'Belum Bayar',
        ];

        $rawStatus = $paymentStatus ? $paymentStatus->status : 'belum bayar';
        $translatedStatus = $statusTranslations[$rawStatus] ?? $rawStatus;

        $stats = [
            'total_alumni' => \App\Models\User::where('angkatan', $user->angkatan)
                ->where('role', 'alumni')
                ->count(),
            'total_events_registered' => $user->eventRegistrations()->count(),
            'profile_completion' => $profileCompletion,
            'payment_status' => $translatedStatus,
        ];
        
        return view('alumni.dashboard', [
            'user' => $user,
            'profile' => $profile,
            'profileCompletion' => $profileCompletion,
            'profile_completion' => $profileCompletion, // Tambahkan versi snake_case untuk kompatibilitas template
            'paymentStatus' => $paymentStatus,
            'payment_info' => $paymentStatus, // Untuk kompatibilitas dengan template
            'upcomingEvents' => $upcomingEvents ?? null,
            'upcoming_events' => $upcoming_events ?? null, // Untuk kompatibilitas dengan template
            'recent_jobs' => $recent_jobs ?? null, // Untuk kompatibilitas dengan template
            'stats' => $stats ?? []
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
