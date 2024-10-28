<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckEmailVerified
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && is_null(Auth::user()->email_verified_at)) {
            return redirect()->route('send.email', Auth::user())
                ->withErrors(['logname' => 'Please verify your email to access this section.']);
        }

        return $next($request);
    }
}
