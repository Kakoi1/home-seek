<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Check if the authenticated user is an admin
        if (!Auth::check() && Auth::user()->role !== 'admin') {

            return redirect()->back()->with('error', 'Unauthorized access for Admin only.');
        }

        // Redirect to home or unauthorized page if not an admin
        return $next($request);
    }
}
