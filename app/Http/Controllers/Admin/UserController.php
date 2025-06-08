<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with('profile')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,sub_admin,department_coordinator,alumni'],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'approved', // Fixed column name
        ];

        // Add angkatan if provided for coordinators
        if ($request->filled('angkatan')) {
            $userData['angkatan'] = $request->angkatan;
        }

        $user = User::create($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:admin,sub_admin,department_coordinator,alumni'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Approve the specified user.
     */
    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'User approved successfully.');
    }

    /**
     * Reject the specified user.
     */
    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'User rejected successfully.');
    }

    public function bulkApprove(Request $request)
    {
        $userIds = $request->input('user_ids', []);
        User::whereIn('id', $userIds)->update(['status' => 'approved']);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna terpilih berhasil disetujui.');
    }

    public function bulkReject(Request $request)
    {
        $userIds = $request->input('user_ids', []);
        User::whereIn('id', $userIds)->update(['status' => 'rejected']);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna terpilih berhasil ditolak.');
    }

    public function bulkChangeRole(Request $request)
    {
        $userIds = $request->input('user_ids', []);
        $newRole = $request->input('new_role');
        if (!$newRole) {
            return redirect()->route('admin.users.index')->with('error', 'Peran baru harus dipilih.');
        }
        User::whereIn('id', $userIds)->update(['role' => $newRole]);
        return redirect()->route('admin.users.index')->with('success', 'Peran pengguna terpilih berhasil diubah.');
    }

    public function bulkSendEmail(Request $request)
    {
        $userIds = $request->input('user_ids', []);
        // Implement email sending logic here, e.g. dispatch jobs
        return redirect()->route('admin.users.index')->with('success', 'Email massal berhasil dikirim ke pengguna terpilih.');
    }

    public function bulkDelete(Request $request)
    {
        $userIds = $request->input('user_ids', []);
        User::whereIn('id', $userIds)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna terpilih berhasil dihapus.');
    }

    /**
     * Display a listing of pending users.
     */
    public function pending()
    {
        $users = User::with('profile')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.pending', compact('users'));
    }

    /**
     * Display a listing of coordinators (both department and angkatan coordinators).
     */
    public function coordinators(Request $request)
    {
        $query = User::with('profile')
            ->where('role', 'department_coordinator')
            ->orWhere('angkatan', '!=', null);

        // Filter by coordinator type if specified
        if ($request->has('type')) {
            if ($request->type === 'department') {
                $query->where('role', 'department_coordinator');
            } elseif ($request->type === 'angkatan') {
                $query->where('angkatan', '!=', null)
                      ->where('role', '!=', 'department_coordinator');
            }
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('angkatan', 'like', '%' . $search . '%');
            });
        }

        $coordinators = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.coordinators', compact('coordinators'));
    }

    /**
     * Display a listing of departments with their coordinators.
     */
    public function departments(Request $request)
    {
        $query = Department::with(['coordinator', 'coordinator.profile']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('coordinator', function($coordQuery) use ($search) {
                      $coordQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $departments = $query->orderBy('name', 'asc')->paginate(10);
        $availableCoordinators = User::where('role', 'department_coordinator')
                                    ->orWhere('role', 'admin')
                                    ->orderBy('name', 'asc')
                                    ->get();

        return view('admin.users.departments', compact('departments', 'availableCoordinators'));
    }

    /**
     * Store a new department.
     */
    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'coordinator_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);

        $department = Department::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'description' => $request->description,
            'coordinator_id' => $request->coordinator_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.users.departments')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    /**
     * Update an existing department.
     */
    public function updateDepartment(Request $request, Department $department)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'coordinator_id' => ['nullable', 'exists:users,id'],
            'is_active' => ['boolean'],
        ]);

        $department->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'description' => $request->description,
            'coordinator_id' => $request->coordinator_id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.users.departments')
            ->with('success', 'Departemen berhasil diperbarui.');
    }

    /**
     * Assign coordinator to department.
     */
    public function assignCoordinator(Request $request, Department $department)
    {
        $request->validate([
            'coordinator_id' => ['required', 'exists:users,id'],
        ]);

        $department->update([
            'coordinator_id' => $request->coordinator_id,
        ]);

        return redirect()->route('admin.users.departments')
            ->with('success', 'Koordinator berhasil di-assign ke departemen.');
    }

    /**
     * Delete a department.
     */
    public function destroyDepartment(Department $department)
    {
        $department->delete();

        return redirect()->route('admin.users.departments')
            ->with('success', 'Departemen berhasil dihapus.');
    }
}
