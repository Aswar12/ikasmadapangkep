<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->approved) {
            Auth::logout();
            return redirect()->route('approval.pending')
                ->with('warning', 'Akun Anda masih menunggu persetujuan admin.');
        }

        return $next($request);
    }
}
