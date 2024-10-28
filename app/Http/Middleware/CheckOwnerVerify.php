<?php
namespace App\Http\Middleware;

use App\Models\Verifications;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckOwnerVerify
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'owner') {
            $verification = Verifications::where('user_id', Auth::id())->first();

            // Check if the verification record exists
            if ($verification) {
                // Check for rejected status
                if ($verification->status === 'rejected') {
                    Auth::logout();

                    // Redirect to login with a rejection message
                    return redirect()->route('login')->withErrors([
                        'login_error' => 'Your verification has been rejected. Please contact support for further assistance.'
                    ]);
                } elseif ($verification->status === 'pending') { // Pending verification
                    Auth::logout();

                    return redirect()->route('login')->withErrors([
                        'login_error' => 'Verification is still pending. Please wait for admin approval.'
                    ]);
                }
            }
        }

        return $next($request);
    }


}

