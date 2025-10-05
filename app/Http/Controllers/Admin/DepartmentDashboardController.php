<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ProgramKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentDashboardController extends Controller
{
    /**
     * Display department dashboard overview
     */
    public function overview()
    {
        $user = auth()->user();
        
        // Get accessible departments
        if ($user->canAccessAllDepartments()) {
            $accessibleDepartments = Department::query();
        } else {
            $accessibleDepartmentIds = $user->getAccessibleDepartments()->pluck('id');
            $accessibleDepartments = Department::whereIn('id', $accessibleDepartmentIds);
        }
        
        // Get department statistics
        $stats = [
            'total_departments' => $accessibleDepartments->count(),
            'active_departments' => $accessibleDepartments->where('is_active', true)->count(),
            'departments_with_coordinator' => $accessibleDepartments->whereNotNull('coordinator_id')->count(),
            'departments_without_coordinator' => $accessibleDepartments->whereNull('coordinator_id')->count(),
        ];

        // Get program statistics per department
        $departmentPrograms = $accessibleDepartments->withCount([
            'programKerja as total_programs',
            'programKerja as active_programs' => function($query) {
                $query->where('status', 'ongoing');
            },
            'programKerja as completed_programs' => function($query) {
                $query->where('status', 'completed');
            }
        ])->get();

        // Get budget analysis
        $budgetAnalysis = Department::select([
            'departments.id',
            'departments.name',
            DB::raw('COALESCE(SUM(programs.budget), 0) as total_budget'),
            DB::raw('COALESCE(SUM(programs.realization), 0) as total_realization'),
            DB::raw('COUNT(programs.id) as program_count')
        ])
        ->leftJoin('programs', 'departments.id', '=', 'programs.department_id')
        ->groupBy('departments.id', 'departments.name')
        ->get();

        // Get recent activities
        $recentPrograms = ProgramKerja::with(['department'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.departments.dashboard', compact(
            'stats', 
            'departmentPrograms', 
            'budgetAnalysis', 
            'recentPrograms'
        ));
    }

    /**
     * Get department performance data for charts
     */
    public function performanceData()
    {
        $departments = Department::with(['programKerja'])->get();
        
        $performanceData = $departments->map(function($department) {
            $programs = $department->programKerja;
            $totalPrograms = $programs->count();
            $completedPrograms = $programs->where('status', 'completed')->count();
            $ongoingPrograms = $programs->where('status', 'ongoing')->count();
            $completionRate = $totalPrograms > 0 ? ($completedPrograms / $totalPrograms) * 100 : 0;
            
            return [
                'name' => $department->name,
                'total_programs' => $totalPrograms,
                'completed_programs' => $completedPrograms,
                'ongoing_programs' => $ongoingPrograms,
                'completion_rate' => round($completionRate, 2),
                'total_budget' => $programs->sum('budget'),
                'total_realization' => $programs->sum('realization')
            ];
        });

        return response()->json($performanceData);
    }

    /**
     * Department detail with programs and budget tracking
     */
    public function show(Department $department)
    {
        $department->load([
            'coordinator',
            'programKerja' => function($query) {
                $query->orderBy('start_date', 'desc');
            }
        ]);

        // Calculate department statistics
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

        // Get program status distribution
        $programsByStatus = $department->programKerja
            ->groupBy('status')
            ->map(function($programs) {
                return $programs->count();
            });

        // Get monthly budget allocation
        $monthlyBudget = $department->programKerja
            ->groupBy(function($program) {
                return $program->start_date->format('Y-m');
            })
            ->map(function($programs) {
                return [
                    'budget' => $programs->sum('budget'),
                    'realization' => $programs->sum('realization'),
                    'count' => $programs->count()
                ];
            });

        return view('admin.departments.show', compact(
            'department', 
            'stats', 
            'programsByStatus', 
            'monthlyBudget'
        ));
    }

    /**
     * Get coordinators available for assignment
     */
    public function getAvailableCoordinators()
    {
        $coordinators = User::where('role', 'department_coordinator')
            ->orWhere('role', 'admin')
            ->orWhere('role', 'sub_admin')
            ->whereDoesntHave('coordinatedDepartment')
            ->get(['id', 'name', 'email']);

        return response()->json($coordinators);
    }

    /**
     * Assign coordinator to department
     */
    public function assignCoordinator(Request $request, Department $department)
    {
        $request->validate([
            'coordinator_id' => 'required|exists:users,id'
        ]);

        $department->update([
            'coordinator_id' => $request->coordinator_id
        ]);

        return redirect()->back()->with('success', 'Koordinator berhasil ditugaskan ke departemen.');
    }

    /**
     * Remove coordinator from department
     */
    public function removeCoordinator(Department $department)
    {
        $department->update([
            'coordinator_id' => null
        ]);

        return redirect()->back()->with('success', 'Koordinator berhasil dihapus dari departemen.');
    }
}