<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dorm;
use App\Models\Room;
use App\Models\Message;
use App\Models\RentForm;
use App\Models\Roomchat;
use App\Events\MessageEvent;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\NotificationEvent;
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
                [$roomId, $userId, 'I am interested in This Room.', $roomchatId]
            );

            // Get the newly created message ID
            $messageId = DB::getPdo()->lastInsertId();

            // Update the roomchat with the new message's ID
            DB::update(
                'UPDATE roomchats SET message_id = ? WHERE id = ?',
                [$messageId, $roomchatId]
            );

            event(new NotificationEvent([

                'reciever' => $room->dorm->user_id,
                'message' => 'I am interested in This Room.',
                'sender' => Auth::id(),
                'rooms' => $roomId,
                'roomid' => $roomchatId,
                'action' => 'inquire',
            ]));

        } else {
            $roomchatId = Roomchat::find($existingRoomchat[0]->id);
        }

        return redirect()->route('room.chat', ['room' => $roomId, 'roomchat' => $roomchatId])->with('success', 'Rom inquire sent successfully!');
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
        $chat = Roomchat::findOrFail($chatId);

        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room not found'
            ], 404);
        }

        if (is_null($chatId)) {
            return response()->json(['status' => 'Room ID is required'], 400);
        }

        $chat_id = ($chat->user_id != $userId) ? $chat->user_id : $chat->other_user_id;


        $message = new Message();
        $message->rooms_id = $roomId;
        $message->user_id = $userId;
        $message->message = $request->message;
        $message->chat_id = $chatId; // Associate the message with the chatroom
        $message->save();

        event(new MessageEvent([

            'reciever' => $chat_id,

        ]));


        return response()->json([
            'status' => 'Message sent successfully',
            'chat_id' => $chatId // Include room_id in the response
        ]);

    }

    // public function sendRentFormUrl($roomId, $dormId)
    // {
    //     $userId = Auth::id();
    //     $room = Room::findOrFail($dormId);
    //     $dorm = Dorm::findOrFail($room->dorm->id);
    //     $chat = Roomchat::findOrFail($roomId);

    //     $chat_id = ($chat->user_id != $userId) ? $chat->user_id : $chat->other_user_id;

    //     // Ensure that only the dorm owner can send the link
    //     if (Auth::id() !== $room->dorm->user_id) {
    //         abort(403, 'Unauthorized action.');
    //         return response()->json(['status' => 'Unauthorized action.'], 403);
    //     }


    //     $available = Room::where('id', $room->id)
    //         ->where('status', true)
    //         ->exists();

    //     if (!$available) {
    //         return response()->json(['status' => 'Room already occupied']);
    //     }
    //     // Generate a signed URL that expires in 1 hour
    //     $url = URL::temporarySignedRoute(
    //         'rent.form',
    //         now()->addHour(),
    //         ['room' => $dormId]
    //     );

    //     // Create a new message with the generated URL
    //     $message = new Message();
    //     $message->rooms_id = $dormId;
    //     $message->user_id = $userId;
    //     $message->message = $url;
    //     $message->chat_id = $roomId; // Associate the message with the chatroom
    //     $message->save();

    //     event(new MessageEvent([

    //         'reciever' => $chat_id,

    //     ]));

    //     return response()->json(['status' => 'Link sent successfully']);
    // }

    public function createBook($roomId, $id = null)
    {
        // Fetch the room by ID, and ensure it exists
        $rooms = Room::where('id', $roomId)->get();

        // If an ID is provided, we're in edit mode
        if ($id) {
            // Find the rent form for the user and room
            $rent = RentForm::where('id', $id)
                ->where('user_id', auth()->id()) // Ensure only the user can edit their own forms
                ->firstOrFail();

            // Convert dates to Carbon instances for formatting in the view
            $rent->start_date = Carbon::parse($rent->start_date);
            $rent->end_date = Carbon::parse($rent->end_date);

            // Pass the rent form and room data to the view
            return view('room.rentForm', compact('rent', 'rooms'));
        }

        // If there's no rent form to edit, just return the room for booking
        return view('room.rentForm', compact('rooms'));
    }




    public function storeBook(Request $request)
    {
        $userId = Auth::id();
        $dorm = Dorm::findOrFail($request->dorm_id);

        // Validate common fields
        $request->validate([
            'start_date' => 'required|date',
            'term' => 'required|in:short_term,long_term',
            'total_price' => 'required',
        ]);

        // Validate fields specific to short-term and long-term rentals
        if ($request->term == 'short_term') {
            $request->validate([
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            // Ensure the end date is within 30 days from the start date
            $startDate = new \DateTime($request->start_date);
            $endDate = new \DateTime($request->end_date);
            $maxEndDate = (clone $startDate)->modify('+30 days');

            if ($endDate > $maxEndDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'The end date must be within 30 days for short-term rentals.'
                ], 422);
            }

            $duration = null;  // No duration for short-term rentals
        } else if ($request->term == 'long_term') {
            $request->validate([
                'duration' => 'required|integer|min:1',
            ]);

            $endDate = null;  // No end date for long-term rentals
            $duration = $request->duration;  // Duration in months for long-term rentals
        }

        // Create the RentForm
        $rentForm = RentForm::create([
            'user_id' => $userId,
            'room_id' => $request->room_id,
            'dorm_id' => $request->dorm_id,
            'term' => $request->term,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date, // For short-term rentals
            'duration' => $duration, // For long-term rentals
            'total_price' => $request->total_price,
            'status' => 'pending', // Initial status
        ]);

        // Create a notification for the room owner
        $notification = Notification::create([
            'user_id' => $dorm->user_id, // Assuming the owner is linked to the room
            'type' => 'Form Submit',
            'data' => 'A new rent form has been submitted for your room.',
            'read' => false,
            'room_id' => $request->room_id,
            'sender_id' => $userId,
        ]);

        // Trigger the notification event
        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => $userId,
            'rooms' => $notification->id,
            'roomid' => $notification->room_id,
            'action' => 'rent',
        ]));

        return redirect()->route('dorms.posted', $dorm->id);
    }

    public function updateBook(Request $request, $id)
    {
        // Fetch the rent form by ID and ensure it belongs to the authenticated user
        $dorm = Dorm::findOrFail($request->dorm_id);

        $rentForm = RentForm::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Validate the incoming request data
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'duration' => 'nullable|integer|min:1', // Only required for long-term rentals
            'term' => 'required|in:short_term,long_term',
            'total_price' => 'required',// Validate the rental type
        ]);

        // Check if it's a short-term rental
        if ($request->input('term') == 'short_term') {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));

            // Ensure the end date is within 30 days of the start date
            if ($endDate->diffInDays($startDate) > 30) {
                return back()->withErrors(['end_date' => 'End date cannot be more than 30 days after the start date.']);
            }

            // Update rent form for short-term
            $rentForm->update([
                'start_date' => $startDate,
                'end_date' => $endDate,
                'duration' => null, // No duration for short-term rentals
                'term' => 'short_term',
                'total_price' => $request->total_price,
            ]);

        } elseif ($request->input('term') == 'long_term') {
            // For long-term rentals, we don't need an end date, only the duration
            $duration = $request->input('duration');

            // Update rent form for long-term
            $rentForm->update([
                'start_date' => Carbon::parse($request->input('start_date')),
                'end_date' => null, // No end date for long-term rentals
                'duration' => $duration,
                'term' => 'long_term',
                'total_price' => $request->total_price,
            ]);
        }

        // Redirect back with success message
        return redirect()->route('dorms.posted', $dorm->id);
    }
    public function cancel($id)
    {
        // Fetch the rent form by ID and ensure it belongs to the authenticated user
        $rentForm = RentForm::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', '!=', 'cancelled') // Make sure it's not already cancelled
            ->firstOrFail();

        // Check if the form is not approved yet
        if ($rentForm->status === 'approved') {
            return redirect()->back()->withErrors('You cannot cancel an already approved form.');
        }

        // Update the status to 'cancelled'
        $rentForm->status = 'cancelled';
        $rentForm->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Rent form cancelled successfully.');
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
    public function addRooms(Request $request, $id)
    {
        $request->validate([
            'rooms_available' => 'required|integer|min:1',
        ]);

        $dorm = Dorm::findOrFail($id); // Find the dorm or throw 404 if not found

        for ($i = 1; $i <= $request->rooms_available; $i++) {
            Room::create([
                'dorm_id' => $dorm->id,
                'number' => ($dorm->rooms()->count() + $i), // Dynamic room number based on existing rooms
                'capacity' => null,
                'price' => null,
                'status' => true, // Set to available by default
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function deleteRooms(Request $request, $id)
    {
        $request->validate([
            'rooms_to_delete' => 'required|array|min:1',
            'rooms_to_delete.*' => 'exists:rooms,id',
        ]);

        // Find the dorm or throw 404 if not found
        $dorm = Dorm::findOrFail($id);

        // Loop through each room to be deleted
        foreach ($request->rooms_to_delete as $roomId) {
            // Find the room
            $room = Room::findOrFail($roomId);

            // Check if the room has an image and delete it
            if (!empty($room->images)) {
                Storage::delete('public/room_images/' . $room->images);
            }

            // Delete the room record
            $room->delete();
        }

        return response()->json(['success' => true]);
    }


}
