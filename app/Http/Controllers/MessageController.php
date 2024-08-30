<?php

// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Dorm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, $dormId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'dorm_id' => $dormId,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->route('dorms.show', $dormId);
    }
    public function markMessagesRead(Request $request)
    {
        $userId = Auth::id();
        $roomId = $request->roomId;

        // Mark all messages in this chatroom as read by the current user
        Message::where('room_id', $roomId)
            ->where('user_id', '!=', $userId)
            ->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }

    public function markasRead(Request $request)
    {
        $userId = Auth::id();
        $roomId = $request->roomId;

        // Mark all messages in this chatroom as read by the current user
        Message::where('chat_id', $roomId)
            ->where('user_id', '!=', $userId)
            ->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }
}

