<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\JobVacancy;
use App\Models\Payment;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display alumni dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get profile completion percentage
        $profile_completion = $this->calculateProfileCompletion($user);
        
        // Get statistics
        $stats = [
            'total_alumni' => User::where('role', 'alumni')->count(),
            'payment_status' => $this->getPaymentStatus($user),
            'upcoming_events' => Event::where('event_date', '>', now())->count(),
            'job_vacancies' => JobVacancy::where('is_active', true)
                ->where('application_deadline', '>', now())
                ->count()
        ];
        
        // Get upcoming events (next 3)
        $upcoming_events = Event::where('event_date', '>', now())
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();
        
        // Get recent job vacancies
        $recent_jobs = JobVacancy::where('is_active', true)
            ->where('application_deadline', '>', now())
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // Get current year payment info
        $payment_info = Payment::where('user_id', $user->id)
            ->where('year_period', date('Y'))
            ->first();
        
        return view('alumni.dashboard', compact(
            'profile_completion',
            'stats',
            'upcoming_events',
            'recent_jobs',
            'payment_info'
        ));
    }
    
    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion($user)
    {
        $profile = Profile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            return 0;
        }
        
        $fields = [
            'gender',
            'birth_place',
            'birth_date',
            'address',
            'phone_number',
            'father_name',
            'mother_name',
            'entry_year',
            'graduation_year'
        ];
        
        $completed = 0;
        $total = count($fields);
        
        foreach ($fields as $field) {
            if (!empty($profile->$field)) {
                $completed++;
            }
        }
        
        // Check user fields
        if (!empty($user->email)) $completed++;
        if (!empty($user->phone)) $completed++;
        
        $total += 2; // Add email and phone to total
        
        return round(($completed / $total) * 100);
    }
    
    /**
     * Get payment status for current year
     */
    private function getPaymentStatus($user)
    {
        $payment = Payment::where('user_id', $user->id)
            ->where('year_period', date('Y'))
            ->first();
        
        if (!$payment) {
            return 'Belum Bayar';
        }
        
        switch ($payment->status) {
            case 'sudah_lunas':
                return 'Lunas';
            case 'menunggu_verifikasi':
                return 'Verifikasi';
            default:
                return 'Belum Bayar';
        }
    }
}
