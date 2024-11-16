<?php

namespace App\Console\Commands;

use App\Events\NotificationEvent;
use App\Models\Notification;
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
                'status' => 'pending',
            ]);
            $rentForm->update([
                'status' => 'active',
            ]);
            $notification = Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Booking Start',
                'data' => '<strong>Booking started</strong><br>' . '<p>Your booking for <strong>' . htmlspecialchars($rentForm->dorm->name) . '</strong> has started successfully.</p><br>' . '<p>Bill Amount: <strong>₱' . number_format($rentForm->total_price, 2) . '</strong></p>' . '<p>Billing Date: <strong>' . htmlspecialchars($rentForm->end_date) . '</strong></p><br>' . '<p>Sent on: ' . now()->format('Y-m-d H:i:s') . '</p>',
                'read' => false,
                'route' => route('user.rentForms'),
                'dorm_id' => $rentForm->dorm_id,
                'sender_id' => 14
            ]);
            event(new NotificationEvent([
                'reciever' => $rentForm->user_id,
                'message' => $notification->data,
                'sender' => 14,
                'rooms' => $notification->id,
                'roomid' => $notification->dorm_id,
                'action' => 'response',
                'route' => route('user.rentForms')
            ]));
        }


    }
}
