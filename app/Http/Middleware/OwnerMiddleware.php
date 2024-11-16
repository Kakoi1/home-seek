<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if user is authenticated and their role is 'owner'
        if (!Auth::check() || Auth::user()->role !== 'owner') {
            // Redirect back if user is not an owner
            dd(Auth::user());
            return redirect()->back()->with('error', 'Unauthorized access for owners only.');
        }

        return $next($request); // Allow access if user is an owner
    }
}
