<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramKerja;
use App\Models\Department; // Moved up
use App\Models\User; // Moved up
use Illuminate\Http\Request;

class ProgramKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ProgramKerja::with(['department', 'penanggungJawab', 'picUser']);

        // Filter by department
        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by program name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $programKerja = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get departments for filter
        $departments = Department::all();
        
        // Get statistics
        $statistics = [
            'total' => ProgramKerja::count(),
            'planning' => ProgramKerja::where('status', 'planning')->count(),
            'ongoing' => ProgramKerja::where('status', 'ongoing')->count(),
            'completed' => ProgramKerja::where('status', 'completed')->count(),
            'delayed' => ProgramKerja::where('status', 'delayed')->count(),
            'cancelled' => ProgramKerja::where('status', 'cancelled')->count(),
            'avg_progress' => ProgramKerja::avg('progress') ?? 0,
        ];

        return view('admin.program-kerja.index', compact('programKerja', 'departments', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        // Define available statuses - this could also come from a config or a dedicated model
        $statuses = ['Not Started', 'In Progress', 'Completed', 'On Hold', 'Cancelled'];
        return view('admin.program-kerja.create', compact('departments', 'users', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'pic_user_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Not Started,In Progress,Completed,On Hold,Cancelled',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'current_progress' => 'nullable|string', // Added from model fillable
        ]);

        // Set pic_user_id to null if it's an empty string
        if (isset($validatedData['pic_user_id']) && $validatedData['pic_user_id'] === '') {
            $validatedData['pic_user_id'] = null;
        }

        // Ensure progress_percentage is 0 if status is Not Started or Cancelled, or if not provided
        if (in_array($validatedData['status'], ['Not Started', 'Cancelled']) || !isset($validatedData['progress_percentage'])) {
            $validatedData['progress_percentage'] = 0;
        }

        // If progress is 100, status should be Completed
        if (isset($validatedData['progress_percentage']) && $validatedData['progress_percentage'] == 100) {
            $validatedData['status'] = 'Completed';
        }


        ProgramKerja::create($validatedData);

        return redirect()->route('admin.program-kerja.index')
                         ->with('success', 'Program Kerja berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgramKerja  $programKerja
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramKerja $programKerja)
    {
        $departments = Department::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $statuses = ['Not Started', 'In Progress', 'Completed', 'On Hold', 'Cancelled'];

        return view('admin.program-kerja.edit', compact('programKerja', 'departments', 'users', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramKerja  $programKerja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramKerja $programKerja)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'pic_user_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|string|in:Not Started,In Progress,Completed,On Hold,Cancelled',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'current_progress' => 'nullable|string',
        ]);

        // Set pic_user_id to null if it's an empty string
        if (isset($validatedData['pic_user_id']) && $validatedData['pic_user_id'] === '') {
            $validatedData['pic_user_id'] = null;
        }

        // Ensure progress_percentage is 0 if status is Not Started or Cancelled, or if not provided
        if (in_array($validatedData['status'], ['Not Started', 'Cancelled']) || !isset($validatedData['progress_percentage'])) {
            $validatedData['progress_percentage'] = 0;
        }

        // If progress is 100, status should be Completed
        if (isset($validatedData['progress_percentage']) && $validatedData['progress_percentage'] == 100) {
            $validatedData['status'] = 'Completed';
        }
        // If status is Completed, progress should be 100
        elseif ($validatedData['status'] == 'Completed' && (!isset($validatedData['progress_percentage']) || $validatedData['progress_percentage'] < 100) ) {
             $validatedData['progress_percentage'] = 100;
        }


        $programKerja->update($validatedData);

        return redirect()->route('admin.program-kerja.index')
                         ->with('success', 'Program Kerja berhasil diperbarui.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgramKerja  $programKerja
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramKerja $programKerja)
    {
        $programKerja->load(['department', 'picUser', 'updates']);
        return view('admin.program-kerja.show', compact('programKerja'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramKerja  $programKerja
     * @return \Illuminate\Http\Response
     */
    /**
     * Display dashboard with statistics and charts
     */
    public function dashboard(Request $request)
    {
        $selectedDepartment = $request->get('department_id');
        $departments = Department::all();
        
        // Get statistics for selected department or all
        $statistics = $this->getStatistics($selectedDepartment);
        $programKerjaData = $this->getProgramKerjaData($selectedDepartment);
        $chartData = $this->getChartData($selectedDepartment);
        
        return view('admin.program-kerja.dashboard', compact(
            'departments',
            'selectedDepartment', 
            'statistics',
            'programKerjaData',
            'chartData'
        ));
    }
    
    private function getStatistics($departmentId = null)
    {
        $baseQuery = ProgramKerja::query();
        
        if ($departmentId) {
            $baseQuery->where('department_id', $departmentId);
        }
        
        return [
            'total_program' => (clone $baseQuery)->count(),
            'planning' => (clone $baseQuery)->where('status', 'planning')->count(),
            'ongoing' => (clone $baseQuery)->where('status', 'ongoing')->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
            'delayed' => (clone $baseQuery)->where('status', 'delayed')->count(),
            'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
            'avg_progress' => (clone $baseQuery)->avg('progress') ?? 0,
            'total_budget' => (clone $baseQuery)->sum('budget'),
            'used_budget' => (clone $baseQuery)->sum('realization')
        ];
    }
    
    private function getProgramKerjaData($departmentId = null)
    {
        $query = ProgramKerja::with(['department'])
            ->select(['id', 'name', 'status', 'progress', 'end_date', 'budget', 'department_id', 'pic_id']);
            
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }
        
        return $query->orderBy('end_date', 'asc')->limit(10)->get();
    }
    
    private function getChartData($departmentId = null)
    {
        $query = ProgramKerja::query();
        
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }
        
        // Progress distribution
        $progressDistribution = $query->selectRaw('
            CASE 
                WHEN progress = 0 THEN "Belum Dimulai"
                WHEN progress BETWEEN 1 AND 25 THEN "1-25%"
                WHEN progress BETWEEN 26 AND 50 THEN "26-50%"
                WHEN progress BETWEEN 51 AND 75 THEN "51-75%"
                WHEN progress BETWEEN 76 AND 99 THEN "76-99%"
                WHEN progress = 100 THEN "Selesai"
                ELSE "Tidak Valid"
            END as range_progress,
            COUNT(*) as count
        ')->groupBy('range_progress')->get();
        
        return [
            'progress_distribution' => $progressDistribution
        ];
    }

    /**
     * Display kanban board view
     */
    public function kanban(Request $request)
    {
        $query = ProgramKerja::with(['department', 'penanggungJawab', 'updates']);

        // Filter by department
        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        $programs = $query->get();
        $departments = Department::all();

        // Group programs by status
        $programsByStatus = [
            'planning' => $programs->where('status', 'planning'),
            'ongoing' => $programs->where('status', 'ongoing'),
            'completed' => $programs->where('status', 'completed'),
            'delayed' => $programs->where('status', 'delayed'),
            'cancelled' => $programs->where('status', 'cancelled'),
        ];

        // Get statistics
        $statistics = [
            'planning' => $programs->where('status', 'planning')->count(),
            'ongoing' => $programs->where('status', 'ongoing')->count(),
            'completed' => $programs->where('status', 'completed')->count(),
            'delayed' => $programs->where('status', 'delayed')->count(),
            'cancelled' => $programs->where('status', 'cancelled')->count(),
            'total' => $programs->count(),
        ];

        return view('admin.program-kerja.kanban', compact(
            'programsByStatus',
            'departments',
            'statistics'
        ));
    }

    /**
     * Update program status via AJAX
     */
    public function updateStatus(Request $request, ProgramKerja $programKerja)
    {
        $request->validate([
            'status' => 'required|in:planning,ongoing,completed,delayed,cancelled'
        ]);

        try {
            $oldStatus = $programKerja->status;
            $programKerja->status = $request->status;
            
            // Auto update progress if status is completed
            if ($request->status === 'completed' && $programKerja->progress < 100) {
                $programKerja->progress = 100;
            }
            
            $programKerja->save();

            // Log the status change (if the updates relationship exists)
            // $programKerja->updates()->create([
            //     'user_id' => auth()->id(),
            //     'update_type' => 'status_change',
            //     'description' => "Status changed from {$oldStatus} to {$request->status}",
            //     'progress' => $programKerja->progress
            // ]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    /**
     * Update program progress via AJAX
     */
    public function updateProgress(Request $request, ProgramKerja $programKerja)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100'
        ]);

        try {
            $oldProgress = $programKerja->progress;
            $programKerja->progress = $request->progress;
            
            // Auto update status based on progress
            if ($request->progress == 100 && $programKerja->status !== 'completed') {
                $programKerja->status = 'completed';
            } elseif ($request->progress > 0 && $programKerja->status === 'planning') {
                $programKerja->status = 'ongoing';
            }
            
            $programKerja->save();

            // Log the progress update (if the updates relationship exists)
            // $programKerja->updates()->create([
            //     'user_id' => auth()->id(),
            //     'update_type' => 'progress_update',
            //     'description' => "Progress updated from {$oldProgress}% to {$request->progress}%",
            //     'progress' => $request->progress
            // ]);

            return response()->json([
                'success' => true,
                'message' => 'Progress updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update progress'
            ], 500);
        }
    }

    /**
     * Add note to program via AJAX
     */
    public function addNote(Request $request, ProgramKerja $programKerja)
    {
        $request->validate([
            'note' => 'required|string|max:500'
        ]);

        try {
            $programKerja->updates()->create([
                'user_id' => auth()->id(),
                'update_type' => 'note',
                'description' => $request->note,
                'progress_percentage' => $programKerja->progress_percentage
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Note added successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add note'
            ], 500);
        }
    }

    /**
     * Get statistics for AJAX updates
     */
    public function getKanbanStatistics()
    {
        $statistics = [
            'planning' => ProgramKerja::where('status', 'planning')->count(),
            'ongoing' => ProgramKerja::where('status', 'ongoing')->count(),
            'completed' => ProgramKerja::where('status', 'completed')->count(),
            'delayed' => ProgramKerja::where('status', 'delayed')->count(),
            'cancelled' => ProgramKerja::where('status', 'cancelled')->count(),
            'total' => ProgramKerja::count(),
        ];

        return response()->json($statistics);
    }

    /**
     * Display calendar view for 5-year term period
     */
    public function calendar(Request $request)
    {
        // Define 5-year term period (2023-2027 as example)
        $termPeriod = [
            'start' => 2023,
            'end' => 2027
        ];
        
        $departments = Department::all();
        
        // Get all programs within the term period
        $programs = ProgramKerja::with(['department'])
            ->whereBetween('start_date', [
                $termPeriod['start'] . '-01-01',
                $termPeriod['end'] . '-12-31'
            ])
            ->orWhereBetween('end_date', [
                $termPeriod['start'] . '-01-01', 
                $termPeriod['end'] . '-12-31'
            ])
            ->get();

        // Convert programs to calendar events
        $calendarEvents = [];
        foreach ($programs as $program) {
            $departmentClass = $this->getDepartmentClass($program->department->name ?? '');
            
            // Start event
            if ($program->start_date) {
                $calendarEvents[] = [
                    'id' => 'start_' . $program->id,
                    'title' => '🚀 ' . $program->name,
                    'start' => $program->start_date,
                    'className' => ['program-event', $departmentClass],
                    'extendedProps' => [
                        'program_id' => $program->id,
                        'department' => $program->department->name ?? '',
                        'department_id' => $program->department_id,
                        'type' => 'start',
                        'progress' => $program->progress ?? 0
                    ]
                ];
            }
            
            // Deadline event
            if ($program->end_date) {
                $calendarEvents[] = [
                    'id' => 'deadline_' . $program->id,
                    'title' => '⏰ ' . $program->name . ' (Deadline)',
                    'start' => $program->end_date,
                    'className' => ['program-event', $departmentClass, 'deadline-event'],
                    'extendedProps' => [
                        'program_id' => $program->id,
                        'department' => $program->department->name ?? '',
                        'department_id' => $program->department_id,
                        'type' => 'deadline',
                        'progress' => $program->progress ?? 0
                    ]
                ];
            }
        }

        // Get statistics
        $statistics = [
            'total_programs' => $programs->count(),
            'completed' => $programs->where('status', 'completed')->count(),
            'ongoing' => $programs->where('status', 'ongoing')->count(),
            'upcoming' => $programs->where('start_date', '>', now())->count(),
            'total_budget' => $programs->sum('budget'),
            'completion_rate' => $programs->count() > 0 ? 
                ($programs->where('status', 'completed')->count() / $programs->count()) * 100 : 0
        ];

        return view('admin.program-kerja.calendar', compact(
            'calendarEvents',
            'departments', 
            'termPeriod',
            'statistics'
        ));
    }

    /**
     * Get program details for modal
     */
    public function getProgramDetails(ProgramKerja $programKerja)
    {
        $programKerja->load(['department', 'penanggungJawab', 'updates']);
        
        $html = view('admin.program-kerja.partials.program-details', compact('programKerja'))->render();
        
        return response()->json(['html' => $html]);
    }

    /**
     * Export calendar to PDF or Excel
     */
    public function exportCalendar(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $departmentId = $request->get('department_id');
        $format = $request->get('format', 'pdf');
        
        $query = ProgramKerja::with(['department']);
        
        // Filter by year
        $query->where(function($q) use ($year) {
            $q->whereYear('start_date', $year)
              ->orWhereYear('end_date', $year);
        });
        
        // Filter by department
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }
        
        $programs = $query->orderBy('start_date')->get();
        
        if ($format === 'pdf') {
            $pdf = \PDF::loadView('admin.program-kerja.exports.calendar-pdf', [
                'programs' => $programs,
                'year' => $year,
                'department' => $departmentId ? Department::find($departmentId) : null
            ]);
            
            return $pdf->download("kalender-program-kerja-{$year}.pdf");
        }
        
        // Excel export would go here
        return redirect()->back()->with('info', 'Excel export coming soon');
    }

    /**
     * Get department CSS class for styling
     */
    private function getDepartmentClass($departmentName)
    {
        $classes = [
            'Pendidikan & Pengembangan Karir' => 'dept-pendidikan',
            'Humas & Pengembangan Jaringan' => 'dept-humas', 
            'Agama, Budaya & Kemasyarakatan' => 'dept-agama',
            'Pembinaan Aparatur Organisasi' => 'dept-aparatur',
            'Keuangan & Kewirausahaan' => 'dept-keuangan'
        ];
        
        foreach ($classes as $name => $class) {
            if (strpos($departmentName, explode(' ', $name)[0]) !== false) {
                return $class;
            }
        }
        
        return 'dept-default';
    }

    public function destroy(ProgramKerja $programKerja)
    {
        // Future consideration: Implement cascading delete or soft delete
        // if ProgramKerjaUpdate records should be handled automatically.
        // For now, directly deleting the ProgramKerja record.
        // Example: $programKerja->updates()->delete(); // If updates should be deleted too

        $programKerja->delete();

        return redirect()->route('admin.program-kerja.index')
                         ->with('success', 'Program Kerja berhasil dihapus.');
    }
}
