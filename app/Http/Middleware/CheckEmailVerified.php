<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckEmailVerified
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && is_null(Auth::user()->email_verified_at)) {
            return redirect()->route('send.email', [Auth::user(), 'verify'])
                ->withErrors(['logname' => 'Please verify your email to access this section.']);
        }

        if (Auth::check() && Auth::user()->active_status) {
            $note = Auth::user()->note;
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'login_error' => 'Your Account has been Deactivated Due to: ' . $note
            ]);
        }
        return $next($request);
    }
}
