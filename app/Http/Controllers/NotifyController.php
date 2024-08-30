<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    public function getNotifications()
    {
        $userId = Auth::id();
        $notifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->with('sender')
            ->get();

        $Countnotifications = Notification::where('user_id', $userId)
            ->where('read', false)
            ->get();

        return response()->json(['notifications' => $notifications, 'unread_count' => $Countnotifications->count()]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->read = true;
        $notification->save();

        return response()->json(['success' => true]);
    }

}
