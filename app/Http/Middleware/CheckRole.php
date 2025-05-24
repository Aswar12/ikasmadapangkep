<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user has any of the required roles
        if (!in_array($user->role, $roles)) {
            // Redirect to appropriate dashboard based on user's actual role
            $defaultRoute = match ($user->role) {
                'admin', 'sub_admin' => 'admin.dashboard',
                'department_coordinator' => 'coordinator.dashboard',
                'alumni' => 'alumni.dashboard',
                default => '/'
            };
            return redirect()->route($defaultRoute);
        }

        return $next($request);
    }
}
