<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Verifications;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function index()
    {
        $usersCount = \App\Models\User::count();

        // Count of property owners (assuming 'role' or 'is_owner' field indicates a property owner)
        $ownersCount = \App\Models\User::where('role', 'owner')->count();

        // Count of listed properties
        $propertiesCount = \App\Models\Dorm::count(); // Assuming Dorm model handles property listings

        // Pass the data to the view
        return view('admin.dashboard', compact('usersCount', 'ownersCount', 'propertiesCount'));

    }

    public function manageUsers()
    {
        $users = User::all();
        $verificationRequests = Verifications::where('status', 'pending')
            ->with('user')
            ->get();
        $req = Verifications::where('status', 'pending')->count();

        return view('admin.manageuser', compact('users', 'verificationRequests', 'req'));
    }

    public function approve($id)
    {
        // Find the verification request by ID
        $verification = Verifications::find($id);

        if ($verification) {
            // Update the status to 'approved'
            $verification->status = 'approved';
            $verification->save();

            $notification = Notification::create([
                'user_id' => $verification->user_id, // Assuming the owner is linked to the room
                'type' => 'verification',
                'data' => 'Your Verification is Approved',
                'read' => false,
                'route' => route('home'),
                'room_id' => null,
                'sender_id' => auth::id(),
            ]);

            event(new NotificationEvent([

                'reciever' => $notification->user_id,
                'message' => $notification->data,
                'sender' => Auth::id(),
                'rooms' => $notification->id,
                'roomid' => $notification->room_id,
                'action' => 'verify',
                'route' => route('home')
            ]));

            return response()->json(['message' => 'Verification approved successfully.']);
        } else {
            return response()->json(['message' => 'Verification not found.'], 404);
        }
    }

    public function reject(Request $request, $id)
    {
        // Find the verification request by ID
        $verification = Verifications::find($id);

        if ($verification) {
            // Update the status to 'rejected' and store the reason
            $verification->status = 'rejected';
            $verification->note = $request->input('reason'); // Assuming 'reason' is the field name
            $verification->save();

            $notification = Notification::create([
                'user_id' => $verification->user_id, // Assuming the owner is linked to the room
                'type' => 'verification',
                'data' => "Your Verification was denied Due to: " . $request->input('reason'),
                'read' => false,
                'room_id' => null,
                'sender_id' => auth::id(),
            ]);

            event(new NotificationEvent([

                'reciever' => $notification->user_id,
                'message' => $notification->data,
                'sender' => Auth::id(),
                'rooms' => $notification->id,
                'roomid' => $notification->room_id,
                'action' => 'verify',
                'route' => route('home')
            ]));

            return response()->json(['message' => 'Verification rejected successfully.']);
        } else {
            return response()->json(['message' => 'Verification not found.'], 404);
        }
    }

    public function activate($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->active_status = false; // Set active status to true
            $user->save();

            return response()->json(['message' => 'User activated successfully.']);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }

    public function deactivate($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->active_status = true; // Set active status to false
            $user->save();

            return response()->json(['message' => 'User deactivated successfully.']);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }

    public function approveDorm(Request $request)
    {
        // Logic for approving dorms
    }

    public function deleteDorm($id)
    {
        // Logic for deleting dorms
    }
}

