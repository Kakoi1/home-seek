<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;

class NotifyCheckIn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-check-in';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify tenants of upcoming check-ins';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch upcoming bookings for today and next 2 days
        $upcomingBookings = \App\Models\RentForm::whereDate('start_date', '>=', now()->toDateString())
            ->whereDate('start_date', '<=', now()->addDays(2)->toDateString())
            ->with('user', 'dorm')
            ->get();

        foreach ($upcomingBookings as $booking) {
            // Calculate the number of days until check-in
            $daysUntilCheckIn = now()->diffInDays($booking->start_date);

            // Create a dynamic message based on how soon the check-in is
            if ($daysUntilCheckIn == 0) {
                $message = 'Your check-in starts today!';
            } elseif ($daysUntilCheckIn == 1) {
                $message = 'Your check-in starts in 1 day!';
            } else {
                $message = 'Your check-in starts in 2 days!';
            }

            // Create the notification
            $notification = Notification::create([
                'user_id' => $booking->user_id, // Assuming the owner is linked to the room
                'type' => 'check-in',        // Change type as needed
                'data' => $message, // Store message in data
                'read' => false,
                'dorm_id' => $booking->dorm_id,
                'sender_id' => $booking->dorm->user_id,              // Optional, set if needed
            ]);
        }

        $this->info('Check-in notifications sent successfully!');
    }
}
