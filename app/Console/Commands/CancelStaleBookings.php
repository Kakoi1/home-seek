<?php

namespace App\Console\Commands;

use App\Models\Dorm;
use App\Models\RentForm;
use App\Models\WalletTransaction;
use DB;
use Illuminate\Console\Command;
use App\Models\Booking; // Adjust to the correct model path
use App\Models\Notification; // Adjust to the correct model path
use App\Events\NotificationEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CancelStaleBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:cancel-stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel pending bookings older than 1 day without a response';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Find all bookings with status 'pending' and older than 1 day
        $staleBookings = RentForm::where('status', 'pending')
            ->where('created_at', '<', Carbon::now()->subDay())
            ->get();

        foreach ($staleBookings as $booking) {
            $dorm = Dorm::find($booking->dorm_id);
            $booking->status = 'cancelled';
            $booking->note = 'Automatically cancelled due to no response for more than 1 day.';

            $user = $booking->user;
            $wallet = $user->wallet;
            $wallet->balance += $booking->total_price;
            $wallet->save();
            $transaction = WalletTransaction::create([
                'user_id' => $user->id,
                'wallet_id' => $user->wallet->id,
                'payment_id' => null,  // Save the payment_id here
                'type' => 'Refund',
                'amount' => '' . $booking->total_price,
                'balance_after' => $user->wallet->balance,
                'status' => 'completed',
                'details' => 'Refund',
            ]);

            $booking->save();
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
                $booking->availability = false;
                $booking->save();
            }

            // Prepare notification message
            $message = "Your booking for <strong>" . $booking->dorm->name . "</strong> has been automatically cancelled due to no response within 24 hours.";

            // Create notification
            $notification = Notification::create([
                'user_id' => $booking->user_id, // Receiver (user)
                'type' => 'warning',
                'data' => $message,
                'read' => false,
                'route' => route('user.rentForms'), // Adjust to the correct route for viewing bookings
                'dorm_id' => $booking->dorm_id,
                'sender_id' => 14, // Use system ID or admin ID
            ]);

            // Trigger notification event
            event(new NotificationEvent([
                'reciever' => $notification->user_id,
                'message' => $notification->data,
                'sender' => 14, // Use system ID or admin ID
                'rooms' => $notification->id,
                'roomid' => null,
                'action' => 'Cancel',
                'route' => route('user.rentForms') // Adjust to the correct route
            ]));
        }

        $this->info('Stale pending bookings have been cancelled and notifications sent.');
        return 0;
    }
}
