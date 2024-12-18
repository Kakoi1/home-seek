<?php

namespace App\Console\Commands;

use App\Events\NotificationEvent;
use App\Models\Billing;
use Carbon\Carbon;
use App\Models\Dorm;
use App\Models\Reviews;

use App\Models\RentForm;
use App\Models\Notification;
use DB;
use Illuminate\Console\Command;

class CompleteRentalsAndRequestReviews extends Command
{
    // Command description
    protected $signature = 'rentform:complete-and-create-reviews';

    protected $description = 'Mark rent forms as completed when the end date is today and create empty reviews for the room/property.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get today's date
        $today = Carbon::today();

        // Find all rent forms with end_date today and status 'pending'
        $rentForms = RentForm::where('end_date', '<=', $today)
            ->where('status', 'active') // Assuming 'pending' means the rent is ongoing
            ->get();

        foreach ($rentForms as $rentForm) {

            $billing = Billing::where('rent_form_id', $rentForm->id)
                ->where('status', 'paid')
                ->first();
            if ($billing) {
                $dorm = Dorm::find($rentForm->dorm_id);
                // Mark rentform as completed
                $rentForm->status = 'completed';
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

                // Create an empty review with null fields for rating and comments
                Reviews::create([
                    'user_id' => $rentForm->user_id,
                    'room_id' => $rentForm->room_id,
                    'dorm_id' => $dorm->id,  // Use the dorm directly from the relation
                    'rating' => null,
                    'comments' => null,
                ]);

                // Send notification to the user
                $notification = Notification::create([
                    'user_id' => $rentForm->user_id,
                    'type' => 'review',
                    'data' => '<strong>Your rent has ended</strong> <br> <p>Your rent has ended on <strong>' . ucfirst($dorm->name) . '</strong> Please leave a review for the Accomodation.</p><br>' . '<p>Sent on: ' . now()->format('Y-m-d H:i:s') . '</p>',
                    'read' => false,
                    'route' => route('myReviews'),
                    'dorm_id' => $dorm->id,
                    'sender_id' => 14,
                ]);
                event(new NotificationEvent([
                    'reciever' => $rentForm->user_id,
                    'message' => $notification->data,
                    'sender' => 14,
                    'rooms' => $notification->id,
                    'roomid' => $notification->dorm_id,
                    'action' => 'response',
                    'route' => route('myReviews')
                ]));
                $ownerNotification = Notification::create([
                    'user_id' => $dorm->user_id, // Assuming the owner is linked to the dorm
                    'type' => 'booking_ended',
                    'data' => '<strong>Booking Ended</strong> <br>' .
                        '<p>The booking for your accommodation <strong>' . ucfirst($dorm->name) . '</strong> has ended.</p><br>' .
                        '<p>Tenant: ' . htmlspecialchars($rentForm->user->name) . '</p>' .  // Assuming user relation exists
                        '<p>End Date: ' . htmlspecialchars($rentForm->end_date) . '</p><br>' .
                        '<p>Sent on: ' . now()->format('Y-m-d H:i:s') . '</p>',
                    'read' => false,
                    'route' => null, // Replace with the appropriate route for owner
                    'dorm_id' => $dorm->id,
                    'sender_id' => 14, // The tenant
                ]);

                event(new NotificationEvent([
                    'reciever' => $dorm->user_id,
                    'message' => $ownerNotification->data,
                    'sender' => 14,
                    'rooms' => $ownerNotification->id,
                    'roomid' => $ownerNotification->dorm_id,
                    'action' => 'notification',
                    'route' => null // Replace with the appropriate route for owner
                ]));
            } else {
                // If the rent form has an unpaid bill, log it
                $this->info('RentForm ID ' . $rentForm->id . ' has an unpaid bill, rent not marked as completed.');
            }
            // Log the action for clarity
            $this->info('RentForm ID ' . $rentForm->id . ' marked as completed. Empty review created.');
        }

        // End of process
        $this->info('All rent forms with today\'s end date have been processed.');
    }
}
