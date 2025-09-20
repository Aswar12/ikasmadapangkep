<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminFinanceController extends Controller
{
    /**
     * Display the alumni dues dashboard.
     */
    public function duesDashboard()
    {
        // Total alumni who should pay dues
        $totalAlumni = User::where('role', 'alumni')->count();

        // Total payments made
        $totalPayments = Payment::sum('amount');

        // Count of alumni who have paid dues
        $alumniPaid = Payment::distinct('user_id')->count('user_id');

        // Count of alumni who have not paid dues
        $alumniNotPaid = $totalAlumni - $alumniPaid;

        // Recent payments
        $recentPayments = Payment::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Monthly payment summary for chart
        $monthlyPayments = Payment::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('admin.finance.dues', compact(
            'totalAlumni',
            'totalPayments',
            'alumniPaid',
            'alumniNotPaid',
            'recentPayments',
            'monthlyPayments'
        ));
    }
}
