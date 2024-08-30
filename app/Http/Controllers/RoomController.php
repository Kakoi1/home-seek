<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\Room;
use App\Models\Message;
use App\Models\RentForm;
use App\Models\Roomchat;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{

    public function index($dormId, $roomId)
    {
        $userId = Auth::id();
        $room = Room::findOrFail($dormId);
        $roomchat = Roomchat::findOrFail($roomId); // Fetch the chatroom by room_id
        $dorm = Dorm::findOrFail($room->dorm_id);

        Message::where('chat_id', $roomId)
            ->where('user_id', '!=', $userId)
            ->update(['is_read' => true]);

        return view('room.chats', compact('room', 'dorm', 'roomchat'));
    }
    public function viewRoom($id, $action)
    {
        // Load the room with its associated dorm
        $room = Room::with('dorm')->findOrFail($id);

        // Fetch the approved rent form for this room (if any)
        $occupied = RentForm::where('room_id', $room->id)
            ->where('status', 'approved') // Active rent status
            ->with('user') // Eager load the associated user
            ->first();

        // Fetch all pending rent forms for this room (inquiries)
        $submited = RentForm::where('room_id', $room->id)
            ->where('status', 'pending') // Pending status indicates inquiries
            ->with('user') // Eager load the associated users
            ->get();

        // Pass all necessary data to the view
        return view('room.edit', compact('room', 'action', 'occupied', 'submited'));
    }


    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $room->number = $request->input('number');
        $room->capacity = $request->input('capacity');
        $room->price = $request->input('price');
        $room->status = $request->has('status');

        // Handle the image upload
        if ($request->hasFile('images')) {
            // Delete the old image if exists
            if ($room->images) {
                Storage::delete('public/room_images/' . $room->images);
            }

            $file = $request->file('images');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/room_images', $filename);
            $room->images = $filename;
        }

        $room->save();

        return redirect()->route('dorms.posted', $room->dorm_id)->with('success', 'Room updated successfully.');
    }

    public function inquireRoom($roomId)
    {
        $room = Room::findOrFail($roomId);
        $userId = Auth::id();

        // Check if a roomchat already exists
        $existingRoomchat = DB::select(
            'SELECT * FROM roomchats 
         WHERE room_id = ? 
         AND ((user_id = ? AND other_user_id = ?) 
         OR (user_id = ? AND other_user_id = ?)) 
         LIMIT 1',
            [$roomId, $userId, $room->dorm->user_id, $room->dorm->user_id, $userId]
        );

        if (!$existingRoomchat) {
            // Create a new roomchat
            DB::insert(
                'INSERT INTO roomchats (user_id, other_user_id, room_id, created_at, updated_at) 
             VALUES (?, ?, ?, NOW(), NOW())',
                [$userId, $room->dorm->user_id, $roomId]
            );

            // Get the newly created roomchat ID
            $roomchatId = DB::getPdo()->lastInsertId();

            // Create a new message
            DB::insert(
                'INSERT INTO messages (rooms_id, user_id, message, chat_id, created_at, updated_at) 
             VALUES (?, ?, ?, ?, NOW(), NOW())',
                [$roomId, $userId, 'I am interested in your dorm.', $roomchatId]
            );

            // Get the newly created message ID
            $messageId = DB::getPdo()->lastInsertId();

            // Update the roomchat with the new message's ID
            DB::update(
                'UPDATE roomchats SET message_id = ? WHERE id = ?',
                [$messageId, $roomchatId]
            );



        } else {
            $roomchatId = Roomchat::find($existingRoomchat[0]->id);
        }

        return redirect()->route('room.chat', ['id' => $roomId, 'rooms_id' => $roomchatId])->with('success', 'Rom inquire sent successfully!');
    }

    public function fetchMessages($dormId, $roomId)
    {

        $messages = Message::where('chat_id', $roomId)
            ->with('user') // Assuming you have a 'user' relationship defined on the Message model
            ->get();

        return response()->json($messages);
    }

    public function fetchRoomChats()
    {
        $userId = Auth::id();

        $roomChats = DB::select("
            SELECT 
            roomchats.id AS roomchat_id, 
            roomchats.room_id, 
            roomchats.user_id, 
            rooms.number AS room_number, 
            users.name AS user_name,
            (SELECT COUNT(*) FROM messages WHERE user_id != ? AND chat_id = roomchats.id AND is_read = 0) as unread_count
            FROM 
                roomchats
            JOIN 
                rooms ON roomchats.room_id = rooms.id
            JOIN 
                users ON roomchats.user_id = users.id
            WHERE 
                roomchats.user_id = ? 
                OR rooms.dorm_id IN (SELECT dorms.id FROM dorms WHERE dorms.user_id = ?)
            ORDER BY 
                roomchats.created_at DESC;

            ", [$userId, $userId, $userId]);

        return response()->json($roomChats);
    }

    public function sendMessage(Request $request, $roomId, $chatId)
    {
        $userId = Auth::id();
        $room = Room::findOrFail($roomId);


        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room not found'
            ], 404);
        }

        if (is_null($chatId)) {
            return response()->json(['status' => 'Room ID is required'], 400);
        }


        $message = new Message();
        $message->rooms_id = $roomId;
        $message->user_id = $userId;
        $message->message = $request->message;
        $message->chat_id = $chatId; // Associate the message with the chatroom
        $message->save();

        return response()->json([
            'status' => 'Message sent successfully',
            'chat_id' => $chatId // Include room_id in the response
        ]);

    }

    public function sendRentFormUrl($roomId, $dormId)
    {
        $userId = Auth::id();
        $room = Room::findOrFail($dormId);
        $dorm = Dorm::findOrFail($room->dorm->id);


        // Ensure that only the dorm owner can send the link
        if (Auth::id() !== $room->dorm->user_id) {
            abort(403, 'Unauthorized action.');
            return response()->json(['status' => 'Unauthorized action.'], 403);
        }


        $available = Room::where('id', $room->id)
            ->where('status', true)
            ->exists();

        if (!$available) {
            return response()->json(['status' => 'Room already occupied']);
        }
        // Generate a signed URL that expires in 1 hour
        $url = URL::temporarySignedRoute(
            'rent.form',
            now()->addHour(),
            ['room' => $dormId]
        );

        // Create a new message with the generated URL
        $message = new Message();
        $message->rooms_id = $dormId;
        $message->user_id = $userId;
        $message->message = $url;
        $message->chat_id = $roomId; // Associate the message with the chatroom
        $message->save();

        return response()->json(['status' => 'Link sent successfully']);
    }

    public function createRentForm($roomId)
    {
        // Find the room by its ID
        $room = Room::findOrFail($roomId);
        $dorm = Dorm::findOrFail($room->dorm_id);


        // Return the view with the room data
        return view('room.rentForm', compact('room', 'dorm'));
    }

    public function create($roomId, $dormId)
    {
        return view('rent-form.create', compact('roomId', 'dormId'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'start_date' => 'required|date',
            'duration' => 'required|integer|min:1',
        ]);

        $rentForm = RentForm::create([
            'user_id' => $userId,
            'room_id' => $request->room_id,
            'dorm_id' => $request->dorm_id,
            'start_date' => $request->start_date,
            'duration' => $request->duration,
            'status' => 'pending', // initial status
        ]);

        Notification::create([
            'user_id' => $request->dorm_id->user_id, // Assuming the owner is linked to the room
            'type' => 'Form Submit',
            'data' => 'A new rent form has been submitted for your room.',
            'read' => false,
            'room_id' => $request->room_id,
            'sender_id' => $userId
        ]);

        return response()->json(['success' => true]);
    }

    public function checkForm(Request $request)
    {
        $userId = Auth::id();

        // Execute the raw SQL query
        $result = DB::select("SELECT EXISTS (
            SELECT 1 
            FROM rent_forms 
            WHERE user_id = ? 
            AND room_id = ?
            AND (status = 'pending' OR status = 'approved')
        ) AS `exists`;", [$userId, $request->roomId]);

        // Extract the 'exists' value from the result
        $existingForm = $result[0]->exists;

        if ($existingForm) {
            // If the user has already submitted a form, return a response indicating so
            return response()->json(['success' => true]);
        } else {
            // If no form exists, return a response indicating so
            return response()->json(['success' => false]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $userId = Auth::id();

        $rentForm = RentForm::findOrFail($id);
        $rentForm->status = $request->input('status');
        $rentForm->save();

        if ($request->input('status') == 'approved') {
            $room = Room::findOrFail($rentForm->room_id);
            $room->status = false;

            Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Form Response',
                'data' => 'Rent Form approved',
                'read' => false,
                'room_id' => $rentForm->room_id,
                'sender_id' => $userId
            ]);

        } else if ($request->input('status') == 'rejected') {
            Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Form Response',
                'data' => 'Rent Form rejected',
                'read' => false,
                'room_id' => $rentForm->room_id,
                'sender_id' => $userId
            ]);
        }

        return redirect()->back()->with('success', 'Rent form status updated successfully.');
    }


}
