<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User; // Moved this line up
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with('coordinator')->get();
        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Department::create($request->all());

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Departemen berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $users = User::all();
        return view('admin.departments.edit', compact('department', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coordinator_id' => 'nullable|exists:users,id', // Validate coordinator_id
        ]);

        $data = $request->all();
        $data['coordinator_id'] = $request->coordinator_id === '' ? null : $request->coordinator_id;

        $department->update($data);

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Departemen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        // Considerations for related data (coordinator, program kerja) would be handled here
        // For now, direct deletion is assumed.
        // Example: Check if department has users or program kerja
        // if ($department->users()->exists() || $department->programKerja()->exists()) {
        //     return redirect()->route('admin.departments.index')
        //                      ->with('error', 'Departemen tidak dapat dihapus karena memiliki data terkait.');
        // }

        $department->delete();

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Departemen berhasil dihapus.');
    }
}
