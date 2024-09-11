<?php

// app/Http/Controllers/DormChatController.php

namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\Room;
use App\Models\Message;
use App\Models\Chatroom;
use App\Events\MessageEvent;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index($dormId, $roomId)
    {
        $userId = Auth::id();
        $dorm = Dorm::findOrFail($dormId);
        $chatroom = Chatroom::findOrFail($roomId); // Fetch the chatroom by room_id

        Message::where('room_id', $roomId)
            ->where('user_id', '!=', $userId)
            ->update(['is_read' => true]);

        return view('dorms.chat', compact('dorm', 'chatroom'));
    }


    public function sendMessage(Request $request, $dormId, $roomId)
    {
        $userId = Auth::id();
        $chat = Chatroom::findOrFail($roomId);

        // Check if the dorm exists

        $chat_id = ($chat->user_id != $userId) ? $chat->user_id : $chat->other_user_id;
        // Identify the owner and the current user


        if (is_null($roomId)) {
            return response()->json(['status' => 'Room ID is required'], 400);
        }


        // Create and save the message
        $messageId = DB::table('messages')->insertGetId([
            'dorm_id' => $dormId,
            'user_id' => $userId,
            'message' => $request->message,
            'room_id' => $roomId, // Use the provided room_id
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        event(new MessageEvent([

            'reciever' => $chat_id,

        ]));
        // Optionally, update the chatroom with the first message ID if not already set


        return response()->json([
            'status' => 'Message sent successfully',
            'room_id' => $roomId // Include room_id in the response
        ]);
    }


    public function fetchMessages($dormId, $roomId)
    {

        $dorm = Dorm::findOrFail($dormId);

        $messages = Message::where('room_id', $roomId)
            ->with('user')
            ->get();


        return response()->json($messages);
    }


    public function inquire($dormId)
    {
        $dorm = Dorm::findOrFail($dormId);
        $userId = Auth::id();

        // Check if the user already inquired and has a chatroom for this dorm
        $existingChatroom = DB::select(
            'SELECT * FROM chatrooms 
         WHERE dorm_id = ? 
           AND ((user_id = ? AND other_user_id = ?) 
           OR (user_id = ? AND other_user_id = ?)) 
         LIMIT 1',
            [$dormId, $userId, $dorm->user_id, $dorm->user_id, $userId]
        );

        if (empty($existingChatroom)) {
            // Create a new chatroom
            $chatroom = new Chatroom();
            $chatroom->user_id = $userId;
            $chatroom->other_user_id = $dorm->user_id; // Add the dorm owner's ID
            $chatroom->dorm_id = $dormId;
            $chatroom->save();

            // Create a new inquiry message
            $message = new Message();
            $message->dorm_id = $dormId;
            $message->user_id = $userId;
            $message->message = "I am interested in your dorm.";
            $message->room_id = $chatroom->id; // Associate the message with the chatroom
            $message->save();

            // Update the chatroom with the new message's id
            $chatroom->message_id = $message->id;
            $chatroom->save();

            event(new NotificationEvent([

                'reciever' => $dorm->user_id,
                'message' => 'I am interested in your dorm.',
                'sender' => Auth::id(),
                'rooms' => $dormId,
                'roomid' => $chatroom->id,
                'action' => 'dorm',
            ]));

        } else {
            // If the chatroom already exists, retrieve the chatroom object
            $chatroom = Chatroom::find($existingChatroom[0]->id);
        }

        return redirect()->route('dorm.chat', ['id' => $dormId, 'room_id' => $chatroom->id])->with('success', 'Inquiry Sent');
    }






    public function fetchChatrooms()
    {
        $userId = Auth::id();

        // Fetch chatrooms associated with the user and unread message counts in a single query
        $chatrooms = DB::select("
            SELECT 
                chatrooms.id AS chatroom_id, 
                chatrooms.dorm_id, 
                chatrooms.user_id, 
                dorms.name AS dorm_name, 
                users.name AS user_name,
                (SELECT COUNT(*) FROM messages WHERE user_id != ? AND room_id = chatrooms.id AND is_read = 0) as unread_count
            FROM chatrooms
            JOIN dorms ON chatrooms.dorm_id = dorms.id
            JOIN users ON chatrooms.user_id = users.id
            WHERE chatrooms.user_id = ? OR dorms.user_id = ?
            ORDER BY chatrooms.created_at DESC
        ", [$userId, $userId, $userId]);

        return response()->json(['chat' => $chatrooms]);
    }


}



