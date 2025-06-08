<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\ProgramKerja;
use App\Models\User; // Assuming User model might be needed for auth user
use App\Models\Department; // Moved Up
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For accessing authenticated user
use Illuminate\Validation\Rule; // Moved Up

class ProgramKerjaController extends Controller
{
    /**
     * Display a listing of the resource for the coordinator's department.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coordinator = Auth::user();
        $departmentId = $coordinator->department_id;

        if (!$departmentId) {
            return redirect()->route('coordinator.dashboard') // Or some other appropriate route
                             ->with('error', 'Anda tidak terkait dengan departemen manapun.');
        }

        $programKerja = ProgramKerja::where('department_id', $departmentId)
                                    ->with(['department', 'picUser'])
                                    ->orderBy('start_date', 'desc')
                                    ->get();

        return view('coordinator.program-kerja.index', compact('programKerja'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coordinator = Auth::user();
        $departmentId = $coordinator->department_id;

        if (!$departmentId) {
            return redirect()->route('coordinator.program-kerja.index')
                             ->with('error', 'Anda tidak terkait dengan departemen untuk membuat Program Kerja.');
        }

        // Fetch users - potentially filter by department or role if needed
        $users = User::orderBy('name')->get();
        $statuses = ['Not Started', 'In Progress', 'Completed', 'On Hold', 'Cancelled'];

        return view('coordinator.program-kerja.create', compact('departmentId', 'users', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coordinator = Auth::user();
        $departmentId = $coordinator->department_id;

        if (!$departmentId) {
            return redirect()->route('coordinator.program-kerja.index')
                             ->with('error', 'Anda tidak terkait dengan departemen untuk menyimpan Program Kerja.');
        }

        $statuses = ['Not Started', 'In Progress', 'Completed', 'On Hold', 'Cancelled']; // For validation rule

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'pic_user_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => ['required', 'string', Rule::in($statuses)],
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'current_progress' => 'nullable|string',
        ]);

        $validatedData['department_id'] = $departmentId;

        if (isset($validatedData['pic_user_id']) && $validatedData['pic_user_id'] === '') {
            $validatedData['pic_user_id'] = null;
        }

        if (in_array($validatedData['status'], ['Not Started', 'Cancelled']) || !isset($validatedData['progress_percentage'])) {
            $validatedData['progress_percentage'] = 0;
        }

        if (isset($validatedData['progress_percentage']) && $validatedData['progress_percentage'] == 100) {
            $validatedData['status'] = 'Completed';
        } elseif ($validatedData['status'] == 'Completed' && (!isset($validatedData['progress_percentage']) || $validatedData['progress_percentage'] < 100)) {
            $validatedData['progress_percentage'] = 100;
        }

        ProgramKerja::create($validatedData);

        return redirect()->route('coordinator.program-kerja.index')
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
        $coordinator = Auth::user();
        $departmentId = $coordinator->department_id;

        if (!$departmentId || $programKerja->department_id != $departmentId) {
            abort(403, 'Anda tidak diizinkan untuk mengedit Program Kerja ini.');
        }

        $users = User::orderBy('name')->get();
        $statuses = ['Not Started', 'In Progress', 'Completed', 'On Hold', 'Cancelled'];

        return view('coordinator.program-kerja.edit', compact('programKerja', 'users', 'statuses'));
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
        $coordinator = Auth::user();
        $departmentId = $coordinator->department_id;

        if (!$departmentId || $programKerja->department_id != $departmentId) {
            abort(403, 'Anda tidak diizinkan untuk memperbarui Program Kerja ini.');
        }

        $statuses = ['Not Started', 'In Progress', 'Completed', 'On Hold', 'Cancelled']; // For validation rule

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'pic_user_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => ['required', 'string', Rule::in($statuses)],
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'current_progress' => 'nullable|string',
        ]);

        // department_id is not updated as it's fixed to the coordinator's department

        if (isset($validatedData['pic_user_id']) && $validatedData['pic_user_id'] === '') {
            $validatedData['pic_user_id'] = null;
        }

        if (in_array($validatedData['status'], ['Not Started', 'Cancelled']) || !isset($validatedData['progress_percentage'])) {
            $validatedData['progress_percentage'] = 0;
        }

        if (isset($validatedData['progress_percentage']) && $validatedData['progress_percentage'] == 100) {
            $validatedData['status'] = 'Completed';
        } elseif ($validatedData['status'] == 'Completed' && (!isset($validatedData['progress_percentage']) || $validatedData['progress_percentage'] < 100)) {
            $validatedData['progress_percentage'] = 100;
        }

        $programKerja->update($validatedData);

        return redirect()->route('coordinator.program-kerja.index')
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
        $coordinator = Auth::user();
        $departmentId = $coordinator->department_id;

        if (!$departmentId || $programKerja->department_id != $departmentId) {
            abort(403, 'Anda tidak diizinkan untuk menghapus Program Kerja ini.');
        }

        // Consider related data like ProgramKerjaUpdates if cascading delete is not set up at DB level
        // $programKerja->updates()->delete();

        $programKerja->delete();

        return redirect()->route('coordinator.program-kerja.index')
                         ->with('success', 'Program Kerja berhasil dihapus.');
    }

    /**
     * Store a new progress update for the specified ProgramKerja.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramKerja  $programKerja
     * @return \Illuminate\Http\Response
     */
    public function storeUpdate(Request $request, ProgramKerja $programKerja)
    {
        $coordinator = Auth::user();
        $departmentId = $coordinator->department_id;

        if (!$departmentId || $programKerja->department_id != $departmentId) {
            abort(403, 'Anda tidak diizinkan untuk memperbarui Program Kerja ini.');
        }

        $validatedData = $request->validate([
            'update_date' => 'required|date',
            'progress_percentage_update' => 'nullable|integer|min:0|max:100',
            'description_update' => 'required|string|max:2000', // Max length for description
        ]);

        // Create ProgramKerjaUpdate
        $programKerjaUpdate = new \App\Models\ProgramKerjaUpdate([
            'user_id' => $coordinator->id,
            'update_date' => $validatedData['update_date'],
            'progress_percentage' => $validatedData['progress_percentage_update'] ?? $programKerja->progress_percentage, // Use current if not provided
            'update_description' => $validatedData['description_update'], // Ensure your model uses 'update_description'
        ]);
        $programKerja->updates()->save($programKerjaUpdate);

        // Update ProgramKerja itself
        $programKerja->current_progress = $validatedData['description_update'];

        if ($request->filled('progress_percentage_update')) {
            $newProgress = $validatedData['progress_percentage_update'];
            $programKerja->progress_percentage = $newProgress;

            // Update status based on new progress, unless manually set to On Hold or Cancelled
            if (!in_array($programKerja->status, ['On Hold', 'Cancelled'])) {
                if ($newProgress == 100) {
                    $programKerja->status = 'Completed';
                } elseif ($newProgress > 0) {
                    $programKerja->status = 'In Progress';
                } else { // newProgress == 0
                    $programKerja->status = 'Not Started';
                }
            }
        }
        // If status is manually set to Completed, ensure progress is 100
        // This logic is usually in the main update method, but can be here if only progress drives status
        // For now, we assume the main status field on the ProgramKerja edit form is the master for 'On Hold' etc.

        $programKerja->save();

        return redirect()->route('coordinator.program-kerja.edit', $programKerja->id)
                         ->with('success', 'Pembaruan progres berhasil ditambahkan.');
    }
}
