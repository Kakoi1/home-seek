<?php

namespace App\Console\Commands;

use App\Events\NotificationEvent;
use App\Models\Notification;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use App\Models\Billing;
use App\Models\RentForm;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessBilling extends Command
{
    protected $signature = 'billing:process';
    protected $description = 'Process billing for rent forms starting today';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::now()->toDateString();

        // Get all RentForms where the start date is today
        $rentForms = RentForm::where('start_date', '<=', $today)
            ->where('status', 'approved') // Only approved rent forms
            ->get();

        foreach ($rentForms as $rentForm) {
            Billing::create([
                'user_id' => $rentForm->user_id,
                'rent_form_id' => $rentForm->id,
                'amount' => $rentForm->total_price,
                'billing_date' => $rentForm->end_date,
                'status' => 'paid',
            ]);
            $rentForm->update([
                'status' => 'active',
            ]);
            $user = $rentForm->dorm->user;
            $wallet = $user->wallet;
            $wallet->balance += $rentForm->total_price;
            $wallet->save();

            // Record the transaction in the owner's wallet
            $transaction = WalletTransaction::create([
                'user_id' => $user->id,
                'wallet_id' => $user->wallet->id,
                'payment_id' => null,  // Save the payment_id here
                'type' => 'Earning',
                'amount' => '+' . $rentForm->total_price,
                'balance_after' => $user->wallet->balance,
                'status' => 'completed',
                'details' => 'Earning',
            ]);

            // Notification for the renter
            $notification = Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Booking Start',
                'data' => '<strong>Booking started</strong><br>' .
                    '<p>Your booking for <strong>' . htmlspecialchars($rentForm->dorm->name) . '</strong> has started successfully.</p><br>' .
                    '<p>Check-in Date: <strong>' . htmlspecialchars($rentForm->start_date) . '</strong></p>' .
                    '<p>Check-out Date: <strong>' . htmlspecialchars($rentForm->end_date) . '</strong></p><br>' .
                    '<p>Sent on: ' . now()->format('Y-m-d H:i:s') . '</p>',
                'read' => false,
                'route' => route('user.rentForms'),
                'dorm_id' => $rentForm->dorm_id,
                'sender_id' => 14
            ]);

            // Trigger the notification event for the renter
            event(new NotificationEvent([
                'reciever' => $rentForm->user_id,
                'message' => $notification->data,
                'sender' => 14,
                'rooms' => $notification->id,
                'roomid' => $notification->dorm_id,
                'action' => 'response',
                'route' => route('user.rentForms')
            ]));

            // Notification for the dorm owner
            $ownerNotification = Notification::create([
                'user_id' => $rentForm->dorm->user_id, // Owner of the dorm
                'type' => 'Earning Received',
                'data' => '<strong>Money Received</strong><br>' .
                    '<p>You have received a payment of <strong>₱' . number_format($rentForm->total_price, 2) . '</strong> for the booking of <strong>' . htmlspecialchars($rentForm->dorm->name) . '</strong>.</p><br>' .
                    '<p>Booking has started.</p><br>' .
                    '<p>Sent on: ' . now()->format('Y-m-d H:i:s') . '</p>',
                'read' => false,
                'route' => route('managetenant'),
                'dorm_id' => $rentForm->dorm_id,
                'sender_id' => $rentForm->user_id
            ]);

            // Trigger the notification event for the owner
            event(new NotificationEvent([
                'reciever' => $rentForm->dorm->user_id,
                'message' => $ownerNotification->data,
                'sender' => $rentForm->user_id,
                'rooms' => $ownerNotification->id,
                'roomid' => $ownerNotification->dorm_id,
                'action' => 'response',
                'route' => route('managetenant')
            ]));

        }


    }
}
