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
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user has the required role
        if ($user->role !== $role) {
            // Redirect based on user's actual role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'alumni':
                    return redirect()->route('alumni.dashboard');
                default:
                    return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
