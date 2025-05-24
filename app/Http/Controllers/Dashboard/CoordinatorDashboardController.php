<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ProgramKerja;
use App\Models\ProgramKerjaUpdate;
use App\Models\User;
use App\Models\CashFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoordinatorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's departments
        $myDepartments = Department::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('is_coordinator', true);
        })->get();
        
        // Get all program kerja from my departments
        $departmentIds = $myDepartments->pluck('id');
        
        $myProgramKerja = ProgramKerja::whereIn('department_id', $departmentIds)
            ->with(['department', 'picUser'])
            ->get();
        
        // Statistics
        $stats = [
            'total_programs' => $myProgramKerja->count(),
            'planning' => $myProgramKerja->where('status', 'planning')->count(),
            'in_progress' => $myProgramKerja->where('status', 'in_progress')->count(),
            'completed' => $myProgramKerja->where('status', 'completed')->count(),
            'delayed' => $myProgramKerja->where('status', 'delayed')->count(),
            'total_budget' => $myProgramKerja->sum('budget'),
            'average_progress' => $myProgramKerja->avg('progress_percentage'),
        ];
        
        // Program kerja by status
        $programsByStatus = [
            'planning' => $myProgramKerja->where('status', 'planning'),
            'in_progress' => $myProgramKerja->where('status', 'in_progress'),
            'completed' => $myProgramKerja->where('status', 'completed'),
            'delayed' => $myProgramKerja->where('status', 'delayed'),
        ];
        
        // Recent updates
        $recentUpdates = ProgramKerjaUpdate::whereIn('program_kerja_id', $myProgramKerja->pluck('id'))
            ->with(['programKerja', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Program kerja yang mendekati deadline
        $nearDeadline = $myProgramKerja->filter(function ($program) {
            if (!$program->end_date) return false;
            $daysLeft = now()->diffInDays($program->end_date, false);
            return $daysLeft >= 0 && $daysLeft <= 30 && $program->status != 'completed';
        })->sortBy(function ($program) {
            return $program->end_date;
        });
        
        // Cash flow summary per department
        $cashFlowSummary = [];
        foreach ($myDepartments as $dept) {
            $income = CashFlow::where('department_id', $dept->id)
                ->where('transaction_type', 'income')
                ->where('status', 'approved')
                ->sum('amount');
                
            $expense = CashFlow::where('department_id', $dept->id)
                ->where('transaction_type', 'expense')
                ->where('status', 'approved')
                ->sum('amount');
                
            $cashFlowSummary[] = [
                'department' => $dept->name,
                'income' => $income,
                'expense' => $expense,
                'balance' => $income - $expense,
            ];
        }
        
        // Team members in my departments
        $teamMembers = User::whereHas('departments', function ($query) use ($departmentIds) {
            $query->whereIn('department_id', $departmentIds);
        })->get();
        
        return view('coordinator.dashboard.index', [
            'myDepartments' => $myDepartments,
            'myProgramKerja' => $myProgramKerja,
            'user' => $user
        ]);
    }
    
    public function updateProgramProgress(Request $request, $programId)
    {
        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'update_description' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);
        
        $program = ProgramKerja::findOrFail($programId);
        
        // Check if user is coordinator of this department
        $isCoordinator = Auth::user()->departments()
            ->where('department_id', $program->department_id)
            ->where('is_coordinator', true)
            ->exists();
            
        if (!$isCoordinator) {
            return back()->with('error', 'Anda tidak memiliki akses untuk update program ini.');
        }
        
        // Update program progress
        $program->progress_percentage = $request->progress_percentage;
        $program->current_progress = $request->update_description;
        
        // Update status based on progress
        if ($request->progress_percentage == 100) {
            $program->status = 'completed';
        } elseif ($request->progress_percentage > 0) {
            $program->status = 'in_progress';
        }
        
        $program->save();
        
        // Create update record
        $update = new ProgramKerjaUpdate();
        $update->program_kerja_id = $program->id;
        $update->user_id = Auth::id();
        $update->update_description = $request->update_description;
        $update->progress_percentage = $request->progress_percentage;
        $update->update_date = now();
        $update->updated_by = Auth::id();
        
        // Handle document upload
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('program-updates', 'public');
            $update->document_path = $path;
        }
        
        $update->save();
        
        return back()->with('success', 'Progress program kerja berhasil diupdate.');
    }
}
