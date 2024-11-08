<?php

namespace App\Console\Commands;

use App\Models\Billing;
use Carbon\Carbon;
use App\Models\Dorm;
use App\Models\Reviews;

use App\Models\RentForm;
use App\Models\Notification;
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

                $dorm->availability = true;
                $dorm->save();
                // Create an empty review with null fields for rating and comments
                Reviews::create([
                    'user_id' => $rentForm->user_id,
                    'room_id' => $rentForm->room_id,
                    'dorm_id' => $dorm->id,  // Use the dorm directly from the relation
                    'rating' => null,
                    'comments' => null,
                ]);

                // Send notification to the user
                Notification::create([
                    'user_id' => $rentForm->user_id,
                    'type' => 'review',
                    'data' => '<strong>Your rent has ended</strong> <br> <p>Please leave a review for the property.</p>',
                    'read' => false,
                    'route' => route('myReviews'),
                    'dorm_id' => $dorm->id,
                    'sender_id' => 14,
                ]);
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
