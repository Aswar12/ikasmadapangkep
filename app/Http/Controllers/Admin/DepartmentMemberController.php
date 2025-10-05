<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DepartmentMember;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentMemberController extends Controller
{
    /**
     * Display department members management page.
     */
    public function index(Department $department)
    {
        // Check if user can manage this department
        if (!auth()->user()->canManageDepartment($department->id)) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola departemen ini.');
        }

        $members = $department->departmentMembers()
            ->with('user')
            ->orderBy('role_in_department', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get available users who are not members of this department
        $availableUsers = User::whereNotIn('id', function($query) use ($department) {
            $query->select('user_id')
                  ->from('department_members')
                  ->where('department_id', $department->id)
                  ->where('status', '!=', 'resigned');
        })->where('status', 'approved')
          ->orderBy('name', 'asc')
          ->get();

        return view('admin.departments.members.index', compact('department', 'members', 'availableUsers'));
    }

    /**
     * Add new member to department.
     */
    public function store(Request $request, Department $department)
    {
        if (!auth()->user()->canManageDepartment($department->id)) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola departemen ini.');
        }

        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role_in_department' => ['required', 'in:coordinator,secretary,treasurer,member,volunteer'],
            'joined_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:500']
        ]);

        // Check if user is already a member
        $existingMember = DepartmentMember::where('user_id', $request->user_id)
            ->where('department_id', $department->id)
            ->where('status', '!=', 'resigned')
            ->first();

        if ($existingMember) {
            return redirect()->back()->with('error', 'User sudah menjadi anggota departemen ini.');
        }

        // Prevent multiple coordinators (except for main coordinator)
        if ($request->role_in_department === 'coordinator') {
            $existingCoordinator = $department->departmentMembers()
                ->where('role_in_department', 'coordinator')
                ->where('status', 'active')
                ->exists();

            if ($existingCoordinator && $department->coordinator_id !== $request->user_id) {
                return redirect()->back()->with('error', 'Departemen sudah memiliki koordinator.');
            }
        }

        DepartmentMember::create([
            'user_id' => $request->user_id,
            'department_id' => $department->id,
            'role_in_department' => $request->role_in_department,
            'joined_at' => $request->joined_at ?? now(),
            'notes' => $request->notes,
            'status' => 'active'
        ]);

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan ke departemen.');
    }

    /**
     * Update member role or status.
     */
    public function update(Request $request, Department $department, DepartmentMember $member)
    {
        if (!auth()->user()->canManageDepartment($department->id)) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola departemen ini.');
        }

        $request->validate([
            'role_in_department' => ['sometimes', 'in:coordinator,secretary,treasurer,member,volunteer'],
            'status' => ['sometimes', 'in:active,inactive,resigned'],
            'resigned_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:500']
        ]);

        // Prevent changing main coordinator role
        if ($member->user_id === $department->coordinator_id && 
            $request->has('role_in_department') && 
            $request->role_in_department !== 'coordinator') {
            return redirect()->back()->with('error', 'Tidak dapat mengubah role koordinator utama.');
        }

        $updateData = $request->only(['role_in_department', 'status', 'notes']);

        if ($request->status === 'resigned') {
            $updateData['resigned_at'] = $request->resigned_at ?? now();
        }

        $member->update($updateData);

        return redirect()->back()->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove member from department.
     */
    public function destroy(Department $department, DepartmentMember $member)
    {
        if (!auth()->user()->canManageDepartment($department->id)) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola departemen ini.');
        }

        // Prevent removing main coordinator
        if ($member->user_id === $department->coordinator_id) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus koordinator utama dari departemen.');
        }

        $member->delete();

        return redirect()->back()->with('success', 'Anggota berhasil dihapus dari departemen.');
    }

    /**
     * Get department member data for AJAX requests.
     */
    public function getMemberData(Department $department, DepartmentMember $member)
    {
        if (!auth()->user()->canViewDepartment($department->id)) {
            abort(403);
        }

        return response()->json([
            'member' => $member->load('user'),
            'role_names' => DepartmentMember::getRoleNames(),
            'status_names' => DepartmentMember::getStatusNames()
        ]);
    }
}