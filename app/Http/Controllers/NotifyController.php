<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\Notification;
use App\Models\RentForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
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
    public function sendUpcomingStayNotification($tenantId)
    {
        // Fetch the tenant's approved RentForm
        $rentForm = RentForm::where('user_id', $tenantId)
            ->where('status', 'approved')
            ->first();

        if (!$rentForm) {
            return response()->json(['success' => false, 'message' => 'No approved rent form found for this tenant.']);
        }
        $today = Carbon::now();
        $startDate = Carbon::parse($rentForm->start_date);
        $remainingTimeInHours = $today->diffInHours($startDate, false);
        // Calculate days or hours until the stay begins
        if ($remainingTimeInHours < 24) {
            $hoursUntilStay = $today->diffInHours($startDate, false);
            if ($hoursUntilStay > 0) {
                $remainingTime = intval($hoursUntilStay) . ' hour' . (intval($hoursUntilStay) > 1 ? 's' : '');
                $timeMessage = "Your stay at {$rentForm->dorm->name} starts in {$remainingTime}! Please be prepared for your check-in.";
            } else {
                $timeMessage = "Your stay at {$rentForm->dorm->name} starts today! Please be prepared for your check-in.";
            }
        } else {
            $daysUntilStay = $today->diffInDays($startDate, false);
            if ($daysUntilStay > 0) {
                $remainingTime = intval($daysUntilStay) . ' day' . (intval($daysUntilStay) > 1 ? 's' : '');
                $timeMessage = "Your stay at {$rentForm->dorm->name} starts in {$remainingTime}! Please be prepared for your check-in.";
            } else {
                $timeMessage = "Your stay at {$rentForm->dorm->name} has already started or is overdue!";
            }
        }
        // Send the notification
        $Notification = Notification::create([
            'user_id' => $tenantId,
            'type' => 'upcoming_stay',
            'data' => "<p>{$timeMessage}</p>",
            'read' => false,
            'route' => null, // Adjust this route as needed
            'dorm_id' => $rentForm->dorm_id,
            'sender_id' => auth()->user()->id // Assuming the owner is logged in
        ]);
        event(new NotificationEvent([
            'reciever' => $Notification->user_id,
            'message' => $Notification->data,
            'sender' => Auth::id(),
            'rooms' => $Notification->id,
            'roomid' => $Notification->room_id,
            'action' => 'Check-in',
            'route' => null
        ]));

        return response()->json(['success' => true, 'message' => 'Notification sent successfully.']);
    }
}
