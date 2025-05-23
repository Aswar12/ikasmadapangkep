<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // Redirect based on user role
        switch ($user->role) {
            case 'admin':
            case 'sub_admin':
                return view('admin.dashboard');
            case 'department_coordinator':
                return view('department.dashboard');
            default:
                return view('alumni.dashboard');
        }
    }
}
