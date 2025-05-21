<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserApprovalController extends Controller
{
    /**
     * Display a listing of users pending approval.
     */
    public function index(): View
    {
        $pendingUsers = User::where('approved', false)
            ->where('email_verified_at', '!=', null)
            ->paginate(10);
        
        return view('admin.users.approval', compact('pendingUsers'));
    }

    /**
     * Approve a user.
     */
    public function approve(User $user): RedirectResponse
    {
        $user->approved = true;
        $user->approved_at = now();
        $user->approved_by = Auth::id();
        $user->active = true;
        $user->save();

        // You could also send notification to user here

        return back()->with('success', 'User has been approved successfully.');
    }

    /**
     * Reject a user.
     */
    public function reject(User $user): RedirectResponse
    {
        // You could implement soft-delete or just mark as inactive
        $user->active = false;
        $user->save();

        // You could also send notification to user here

        return back()->with('success', 'User has been rejected.');
    }

    /**
     * Batch approve multiple users.
     */
    public function batchApprove(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        User::whereIn('id', $validated['users'])->update([
            'approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'active' => true,
        ]);

        return back()->with('success', count($validated['users']) . ' users have been approved.');
    }
}
