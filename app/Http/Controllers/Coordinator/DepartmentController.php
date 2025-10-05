<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:department_coordinator');
    }

    /**
     * Show coordinator's department dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();
        $department = $user->coordinatedDepartment;
        
        if (!$department) {
            return redirect()->route('dashboard')->with('error', 'Anda belum ditugaskan sebagai koordinator departemen.');
        }

        // Get department statistics
        $stats = [
            'total_programs' => $department->programKerja->count(),
            'active_programs' => $department->programKerja->where('status', 'ongoing')->count(),
            'completed_programs' => $department->programKerja->where('status', 'completed')->count(),
            'total_budget' => $department->programKerja->sum('budget'),
            'total_realization' => $department->programKerja->sum('realization'),
        ];

        // Get recent programs
        $recentPrograms = $department->programKerja()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get programs by status
        $programsByStatus = $department->programKerja
            ->groupBy('status')
            ->map(function($programs) {
                return $programs->count();
            });

        return view('coordinator.dashboard', compact(
            'department', 
            'stats', 
            'recentPrograms', 
            'programsByStatus'
        ));
    }

    /**
     * Show department details for coordinator
     */
    public function show()
    {
        $user = auth()->user();
        $department = $user->coordinatedDepartment;
        
        if (!$department) {
            return redirect()->route('coordinator.dashboard')->with('error', 'Departemen tidak ditemukan.');
        }

        $department->load(['programKerja' => function($query) {
            $query->orderBy('start_date', 'desc');
        }]);

        // Calculate statistics
        $stats = [
            'total_programs' => $department->programKerja->count(),
            'active_programs' => $department->programKerja->where('status', 'ongoing')->count(),
            'completed_programs' => $department->programKerja->where('status', 'completed')->count(),
            'total_budget' => $department->programKerja->sum('budget'),
            'total_realization' => $department->programKerja->sum('realization'),
            'budget_utilization' => $department->programKerja->sum('budget') > 0 
                ? ($department->programKerja->sum('realization') / $department->programKerja->sum('budget')) * 100 
                : 0
        ];

        return view('coordinator.department.show', compact('department', 'stats'));
    }

    /**
     * Show programs for coordinator's department
     */
    public function programs()
    {
        $user = auth()->user();
        $department = $user->coordinatedDepartment;
        
        if (!$department) {
            return redirect()->route('coordinator.dashboard')->with('error', 'Departemen tidak ditemukan.');
        }

        $programs = $department->programKerja()
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('coordinator.programs.index', compact('department', 'programs'));
    }
}