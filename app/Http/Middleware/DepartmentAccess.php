<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $permission
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $permission = 'view'): Response
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Get department ID from route parameter
        $departmentId = $request->route('department') ? $request->route('department')->id : null;
        
        // Check permissions based on requested action
        switch ($permission) {
            case 'manage':
                if (!$user->canManageDepartment($departmentId)) {
                    abort(403, 'Anda tidak memiliki akses untuk mengelola departemen ini.');
                }
                break;
                
            case 'view':
                if (!$user->canViewDepartment($departmentId)) {
                    abort(403, 'Anda tidak memiliki akses untuk melihat departemen ini.');
                }
                break;
                
            case 'admin':
                if (!$user->canAccessAllDepartments()) {
                    abort(403, 'Akses ini hanya untuk admin.');
                }
                break;
        }

        return $next($request);
    }
}