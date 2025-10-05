<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ProgramKerja;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF; // Barryvdh\DomPDF

class ReportController extends Controller
{
    /**
     * Department reports
     */
    public function department(Request $request)
    {
        $selectedDepartment = $request->get('department_id');
        $departments = Department::all();
        
        // Get department statistics
        $departmentStats = $this->getDepartmentStatistics($selectedDepartment);
        
        return view('admin.reports.department', compact(
            'departments',
            'selectedDepartment',
            'departmentStats'
        ));
    }
    
    /**
     * Program Kerja reports
     */
    public function programKerja(Request $request)
    {
        $selectedDepartment = $request->get('department_id');
        $format = $request->get('format', 'pdf');
        
        $query = ProgramKerja::with(['department', 'penanggungJawab']);
        
        if ($selectedDepartment) {
            $query->where('department_id', $selectedDepartment);
        }
        
        $programKerjaData = $query->get();
        
        $data = [
            'programKerjaData' => $programKerjaData,
            'selectedDepartment' => $selectedDepartment ? Department::find($selectedDepartment) : null,
            'generatedAt' => Carbon::now()->format('d F Y H:i:s')
        ];
        
        if ($format === 'pdf') {
            $pdf = PDF::loadView('admin.reports.program-kerja-pdf', $data);
            return $pdf->download('laporan-program-kerja-' . date('Y-m-d') . '.pdf');
        }
        
        // Default to view
        return view('admin.reports.program-kerja', $data);
    }
    
    /**
     * Financial reports
     */
    public function finance(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $year = $request->get('year', Carbon::now()->year);
        
        // Payment statistics
        $paymentStats = Payment::selectRaw('
            MONTH(created_at) as month,
            COUNT(*) as total_payments,
            SUM(amount) as total_amount,
            COUNT(CASE WHEN status = "verified" THEN 1 END) as verified_payments,
            SUM(CASE WHEN status = "verified" THEN amount ELSE 0 END) as verified_amount
        ')
        ->whereYear('created_at', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        
        // Cash flow data (if you have cash_flows table)
        $cashFlowData = collect(); // Placeholder for now
        
        return view('admin.reports.finance', compact(
            'paymentStats',
            'cashFlowData',
            'period',
            'year'
        ));
    }
    
    /**
     * Export financial report to PDF
     */
    public function exportFinance(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $year = $request->get('year', Carbon::now()->year);
        
        // Get financial data
        $paymentStats = Payment::selectRaw('
            MONTH(created_at) as month,
            COUNT(*) as total_payments,
            SUM(amount) as total_amount,
            COUNT(CASE WHEN status = "verified" THEN 1 END) as verified_payments,
            SUM(CASE WHEN status = "verified" THEN amount ELSE 0 END) as verified_amount
        ')
        ->whereYear('created_at', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        
        $data = [
            'paymentStats' => $paymentStats,
            'period' => $period,
            'year' => $year,
            'generatedAt' => Carbon::now()->format('d F Y H:i:s')
        ];
        
        $pdf = PDF::loadView('admin.reports.finance-pdf', $data);
        return $pdf->download('laporan-keuangan-' . $year . '.pdf');
    }
    
    private function getDepartmentStatistics($departmentId = null)
    {
        $query = Department::query();
        
        if ($departmentId) {
            $query->where('id', $departmentId);
        }
        
        return $query->withCount([
            'programKerja as total_programs',
            'programKerja as completed_programs' => function($q) {
                $q->where('status', 'completed');
            },
            'programKerja as in_progress_programs' => function($q) {
                $q->where('status', 'ongoing');
            },
            'users as total_members' => function($q) {
                $q->where('is_active', true);
            }
        ])->get();
    }
}