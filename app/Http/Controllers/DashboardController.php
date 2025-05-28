<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Check if user has role attribute
        if (!isset($user->role)) {
            // Default to alumni dashboard if role is not set
            return view('dashboard.alumni');
        }

        // Redirect based on user role
        switch ($user->role) {
            case 'admin':
            case 'sub_admin':
                return view('dashboard.admin');
            case 'department_coordinator':
                return view('dashboard.coordinator');
            default:
                return view('dashboard.alumni');
        }
    }
}
