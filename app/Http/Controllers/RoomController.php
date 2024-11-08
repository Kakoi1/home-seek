<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dorm;
use App\Models\Room;
use App\Models\Message;
use App\Models\Reviews;
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
                'route' => route('managetenant')
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

    public function createBook(Request $request)
    {
        $id = $request->rent_id;

        if ($id) {
            // Attempt to find the rent form with the provided id for the authenticated user
            $rent = RentForm::where('id', $id)
                ->where('user_id', auth()->id()) // Ensure only the user can edit their own forms
                ->firstOrFail();
            $property = Dorm::where('id', $rent->dorm_id) // Ensure only the user can edit their own forms
                ->firstOrFail();

            // Pass the rent form to the view
            return view('room.rentForm', compact('rent', 'property'));
        }

        // Optional fallback if there's no rent form to edit (if you want to return room data here)
        // $rooms = Room::all(); // Retrieve available rooms
        // return view('room.rentForm', compact('rooms'));

        abort(404); // Send a 404 error if no ID was provided or form not found
    }





    public function storeBook(Request $request)
    {
        $userId = Auth::id();
        $request->validate([
            'dorm_id' => 'required',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'guests' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);
        $dorm = Dorm::findOrFail($request->dorm_id);
        // Save the booking
        RentForm::create([
            'user_id' => $userId, // Assuming the user is logged in
            'dorm_id' => $request->input('dorm_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'guest' => $request->input('guests'),
            'total_price' => $request->input('total_price'),
            'status' => 'pending' // Default status
        ]);

        // Create a notification for the room owner
        $notification = Notification::create([
            'user_id' => $dorm->user_id, // Assuming the owner is linked to the room
            'type' => 'Form Submit',
            'data' => '<strong>Someone Booked</strong> <br> <pSomeone Booked your Property</p><br> <p>Date: ' . now() . '</p>',
            'read' => false,
            'route' => route('managetenant'),
            'dorm_id' => $request->dorm_id,
            'sender_id' => $userId,
        ]);

        // Trigger the notification event
        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => $userId,
            'rooms' => $notification->id,
            'roomid' => $notification->dorm_id,
            'action' => 'rent',
            'route' => route('managetenant')
        ]));
        $dorm->availability = true;
        $dorm->save();
        return redirect()->route('user.rentForms')->with('success', 'Booking Created!');
    }

    public function updateBook(Request $request, $id)
    {
        // Fetch the rent form by ID and ensure it belongs to the authenticated user
        {
            // Retrieve the rent form record and the associated property
            $rent = RentForm::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
            $property = Dorm::findOrFail($rent->dorm_id);

            // Validate the form data, including guests within limits
            $request->validate([
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
                'guest' => "required|integer|min:1|max:{$property->capacity}",
                'total_price' => 'required|numeric|min:0',
            ]);

            // Update the rent form with validated data
            $rent->update([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'guest' => $request->guest,
                'total_price' => $request->total_price,
            ]);

            return redirect()->route('user.rentForms')->with('success', 'Booking updated successfully!');
        }
    }
    public function cancel(Request $request, $id)
    {
        // Fetch the rent form by ID and ensure it belongs to the authenticated user
        $rentForm = RentForm::where('id', $id)
            ->with('dorm')
            ->where('user_id', auth()->id())
            ->where('status', '!=', 'cancelled') // Make sure it's not already cancelled
            ->firstOrFail();
        $message = '';
        $data = '';

        if ($request->cancelReason == 'Other') {
            $request->cancelReason = $request->otherReasonText;
        }

        // Check if the form is not approved yet
        if ($rentForm->status === 'approved') {
            $rentForm->note = $request->cancelReason;
            $message = 'Cancellation Request has Sent';
            $data = 'Booking Cancellation request';
        } else {
            $dorm = Dorm::find($rentForm->dorm_id);
            $rentForm->status = 'cancelled';
            $rentForm->note = $request->cancelReason;
            $message = 'Booking form cancelled successfully';
            $data = 'Booking Cancelled';
            $dorm->availability = false;
            $dorm->save();
        }
        // Redirect back with success message


        $notification = Notification::create([
            'user_id' => $rentForm->dorm->user_id, // Assuming the owner is linked to the room
            'type' => 'Booking Cancellation',
            'data' => $data,
            'read' => false,
            'route' => route('managetenant'),
            'dorm_id' => $rentForm->dorm_id,
            'sender_id' => auth()->id(),
        ]);

        // Trigger the notification event
        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => $notification->sender_id,
            'rooms' => $notification->id,
            'roomid' => $notification->dorm_id,
            'action' => 'rent',
            'route' => route('managetenant')
        ]));
        $rentForm->save();
        return redirect()->back()->with('success', $message);
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
        $dorm = Dorm::find($rentForm->dorm_id);

        if ($request->input('status') == 'approved') {

            $notification = Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Form Response',
                'data' => 'Booking Form approved',
                'read' => false,
                'route' => route('user.rentForms'),
                'dorm_id' => $rentForm->dorm_id,
                'sender_id' => $userId
            ]);
            $dorm->availability = true;
            $dorm->save();

        } else if ($request->input('status') == 'rejected') {
            $notification = Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Form Response',
                'data' => 'Booking Form rejected',
                'read' => false,
                'route' => route('user.rentForms'),
                'dorm_id' => $rentForm->dorm_id,
                'sender_id' => $userId
            ]);
            $rentForm->note = $request->rejection_reason;
            $dorm = Dorm::find($rentForm->dorm_id);
            $dorm->availability = false;
            $dorm->save();
        }

        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => $userId,
            'rooms' => $notification->id,
            'roomid' => $notification->dorm_id,
            'action' => 'response',
            'route' => route('user.rentForms')
        ]));
        $rentForm->save();
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

    public function leaveRent(Request $request, $id)
    {

        $rentForm = RentForm::findOrFail($id);
        $rentForm->status = 'completed';
        $rentForm->note = $request->input('leaveReason');
        $rentForm->save();

        Reviews::create([
            'user_id' => $rentForm->user_id,
            'room_id' => $rentForm->room_id,
            'dorm_id' => $rentForm->room->dorm_id,  // Assuming property_id refers to the dorm
            'rating' => null,  // Leave the rating as null
            'comments' => null,  // Leave the comments as null
        ]);

        $notification = Notification::create([
            'user_id' => $rentForm->dorm->user_id, // Assuming the owner is linked to the room
            'type' => 'review',
            'data' => $rentForm->user->name . ' has left From your Property',
            'read' => false,
            'dorm_id' => $rentForm->dorm_id,
            'sender_id' => $rentForm->user_id
        ]);

        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => $rentForm->user_id,
            'rooms' => $notification->id,
            'roomid' => $notification->room_id,
            'action' => 'rent',
            'route' => route('managetenant')
        ]));

        return redirect()->back();
    }
    public function notifyTenant($id)
    {
        $rentForm = RentForm::findOrFail($id);

        $notification = Notification::create([
            'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
            'type' => 'Bills',
            'data' => 'Owner is Notifying you for payment',
            'read' => false,
            'route' => route('user.rentForms'),
            'dorm_id' => $rentForm->dorm_id,
            'sender_id' => Auth::id()
        ]);

        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => $rentForm->user_id,
            'rooms' => $notification->id,
            'roomid' => $notification->room_id,
            'action' => 'Bills',
            'route' => route('user.rentForms')
        ]));
        return redirect()->back();
    }
}
