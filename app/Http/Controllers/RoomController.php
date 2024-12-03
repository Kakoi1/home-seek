<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use App\Models\Dorm;
use App\Models\Reviews;
use App\Models\RentForm;
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

        abort(404); // Send a 404 error if no ID was provided or form not found
    }
    public function getRentForms($id)
    {
        // Fetch RentForms for a specific dorm that are approved, active, or pending
        $rentForms = RentForm::where('dorm_id', $id)
            ->whereIn('status', ['approved', 'active', 'pending'])
            ->get();

        // Return the rent forms as JSON to be used in the frontend
        return response()->json($rentForms);
    }


    public function storeBook(Request $request)
    {
        $userId = Auth::id();

        // Validate incoming data
        $request->validate([
            'dorm_id' => 'required',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'guests' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        // Find the dorm, or fail if not found
        $dorm = Dorm::findOrFail($request->dorm_id);

        // Check if the dorm is unavailable or flagged
        if ($dorm->flag) {
            return response()->json(['status' => 'error', 'message' => 'Accommodation not available']);
        }
        $startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d');

        // Raw SQL to check if there are any overlapping reservations
        $overlapExists = DB::selectOne("
        SELECT EXISTS (
            SELECT 1
            FROM rent_forms
            WHERE dorm_id = ?
            AND (
                status = 'pending'
                OR status = 'active'
                OR status = 'approved'
            )
            AND (
                (start_date BETWEEN ? AND ?)
                OR (end_date BETWEEN ? AND ?)
                OR (start_date <= ? AND end_date >= ?)
            )
        ) AS overlap_exists
    ", [$dorm->id, $startDate, $endDate, $startDate, $endDate, $startDate, $endDate]);

        if ($overlapExists->overlap_exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'The selected dates are already booked for this Accommodation.'
            ]);
        }



        // Fetch the user's wallet
        $user = Auth::user();
        $wallet = $user->wallet;  // This assumes the user has a 'wallet' relationship defined
        $walletBalance = $wallet->balance;

        // Check if the wallet balance is sufficient
        if ($walletBalance < $request->total_price) {
            return response()->json(['status' => 'error', 'message' => 'Insufficient balance in your wallet']);
        }

        // Save the booking (RentForm)
        $rentForm = RentForm::create([
            'user_id' => $userId,
            'dorm_id' => $request->input('dorm_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'guest' => $request->input('guests'),
            'total_price' => $request->input('total_price'),
            'status' => 'pending',  // Default status
        ]);

        // Deduct the total price from the user's wallet balance


        // Create a notification for the dorm owner
        $notification = Notification::create([
            'user_id' => $dorm->user_id, // Owner of the dorm
            'type' => 'Form Submit',
            'data' => '<strong>Someone Booked</strong> <br> <p>Someone booked your accommodation <strong>' . $dorm->name . '</strong></p><br> <p>Date: ' . now()->format('Y-m-d H:i:s') . '</p>',
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

        // Update dorm availability (mark as unavailable)
        $dorm->availability = false;
        $dorm->save();

        // Respond with success message
        return response()->json([
            'status' => 'success',
            'message' => 'Booking Created!',
        ]);
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
            $rentForm->note = $request->cancelReason == 'Other' ? $request->otherReasonText : $request->cancelReason;
            $message = 'Cancellation Request has Sent';
            $data = '<strong>Booking Cancellation request</strong><br>' .
                '<p>Cancellation request: ' . htmlspecialchars($rentForm->note) . ' on <strong>' . htmlspecialchars($rentForm->dorm->name) . '</strong></p><br>' .
                '<p>Sent on ' . now()->format('Y-m-d H:i:s') . '</p>';
            $rentForm->save();
        } else {
            $dorm = Dorm::find($rentForm->dorm_id);
            $rentForm->status = 'cancelled';
            $rentForm->note = $request->cancelReason == 'Other' ? $request->otherReasonText : $request->cancelReason;
            $message = 'Booking form cancelled successfully';
            $data = '<strong>Booking Cancellation</strong><br>' .
                '<p>Booking Cancelled due to: ' . htmlspecialchars($rentForm->note) . ' on <strong>' . htmlspecialchars($rentForm->dorm->name) . '</strong></p><br>' .
                '<p>Sent on' . now()->format('Y-m-d H:i:s') . '</p>';
            $rentForm->save();
            $activeRentFormsExist = DB::selectOne("
                SELECT EXISTS (
                    SELECT 1
                    FROM rent_forms
                    WHERE dorm_id = ?
                    AND status IN ('pending', 'active', 'approved')
                ) AS rent_form_exists
            ", [$dorm->id]);

            if (!$activeRentFormsExist->rent_form_exists) {
                // If no active, pending, or approved rent forms exist, mark dorm as available
                $dorm->availability = false;
                $dorm->save();
            }

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

        return redirect()->back()->with('success', $message);
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
                'data' => '<strong>Booking Approved</strong><br>' .
                    '<p>Congratulations! Your booking at <strong>' . htmlspecialchars($dorm->name) . '</strong> has been successfully approved.</p>' .
                    '<p>And a ₱' . number_format($rentForm->total_price, 2) . ' has deducted to your wallet for payment.</p>' .
                    '<p>Please prepare for your stay and let us know if you have any questions.</p>' .
                    '<p>Date Approved: ' . now()->format('Y-m-d H:i:s') . '</p>' .
                    '<p>We look forward to hosting you!</p>',
                'read' => false,
                'route' => route('user.rentForms'),
                'dorm_id' => $rentForm->dorm_id,
                'sender_id' => $userId
            ]);
            $user = $rentForm->user;
            $wallet = $user->wallet;
            $wallet->balance -= $rentForm->total_price;
            $wallet->save();
            $transaction = WalletTransaction::create([
                'user_id' => $user->id,
                'wallet_id' => $user->wallet->id,
                'payment_id' => null,  // Save the payment_id here
                'type' => 'payment',
                'amount' => '-' . $rentForm->total_price,
                'balance_after' => $user->wallet->balance,
                'status' => 'completed',
                'details' => 'Payment',
            ]);
            $dorm->availability = true;
            $rentForm->save();
            $dorm->save();

        } else if ($request->input('status') == 'rejected') {
            $notification = Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Form Response',
                'data' => '<strong>Booking rejected</strong><br>' .
                    '<p>Booking rejected: ' . htmlspecialchars($request->rejection_reason) . ' on ' . htmlspecialchars($dorm->name) . '</p><br>' .
                    '<p>Date: ' . now()->format('Y-m-d H:i:s') . '</p>',

                'read' => false,
                'route' => route('user.rentForms'),
                'dorm_id' => $rentForm->dorm_id,
                'sender_id' => $userId
            ]);
            $rentForm->note = $request->rejection_reason;
            $rentForm->save();
            $dorm = Dorm::find($rentForm->dorm_id);

            $activeRentFormsExist = DB::selectOne("
            SELECT EXISTS (
                SELECT 1
                FROM rent_forms
                WHERE dorm_id = ?
                AND status IN ('pending', 'active', 'approved')
            ) AS rent_form_exists
        ", [$dorm->id]);

            if (!$activeRentFormsExist->rent_form_exists) {
                // If no active, pending, or approved rent forms exist, mark dorm as available
                $dorm->availability = false;
                $dorm->save();
            }

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

        return redirect()->back()->with('success', 'Rent form status updated successfully.');
    }

    public function notifyTenant($id)
    {
        $rentForm = RentForm::findOrFail($id);

        $notification = Notification::create([
            'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
            'type' => 'Bills',
            'data' => '<strong>Payment Reminder</strong><br><p>The owner has sent a notification regarding your upcoming payment.</p><br><p>Date: ' . now()->format('Y-m-d H:i:s') . '</p>',
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
            'roomid' => $notification->dorm_id,
            'action' => 'Bills',
            'route' => route('user.rentForms')
        ]));
        return redirect()->back();
    }
}
