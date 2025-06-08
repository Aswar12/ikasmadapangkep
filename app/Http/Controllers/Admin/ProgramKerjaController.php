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
    public function index()
    {
        $programKerja = ProgramKerja::with(['department', 'picUser'])->get();
        return view('admin.program-kerja.index', compact('programKerja'));
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramKerja  $programKerja
     * @return \Illuminate\Http\Response
     */
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
