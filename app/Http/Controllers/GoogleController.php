<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if ($finduser) {
                if (!$finduser->role) {
                    return view('emails.collect_email_phone', ['user' => $finduser])->with('success', 'Provide additional information. to login');
                } else {
                    Auth::login($finduser);
                    if ($finduser->role == 'owner') {
                        return redirect()->route('owner.Dashboard');
                    } else {
                        return redirect('/home');
                    }

                }

            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'name' => $user->name,
                    'google_id' => $user->id,
                    'email_verified_at' => now()
                ]);

                return view('emails.collect_email_phone', ['user' => $newUser])->with('success', 'Provide additional information. to login');
            }

        } catch (Exception $e) {
            return redirect('/login');
        }
    }
}
