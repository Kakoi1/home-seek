<?php

namespace App\Console\Commands;

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
        $rentForms = RentForm::where('end_date', $today)
            ->where('status', 'active') // Assuming 'pending' means the rent is ongoing
            ->get();

        foreach ($rentForms as $rentForm) {
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
                'dorm_id' => $rentForm->room->dorm_id,  // Assuming property_id refers to the dorm
                'rating' => null,  // Leave the rating as null
                'comments' => null,  // Leave the comments as null
            ]);

            $notification = Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'review',
                'data' => 'Your Rent has Ended',
                'read' => false,
                'dorm_id' => $rentForm->dorm_id,
                'sender_id' => null
            ]);

            // Log the action for clarity
            $this->info('RentForm ID ' . $rentForm->id . ' marked as completed. Empty review created.');
        }

        // End of process
        $this->info('All rent forms with today\'s end date have been processed.');
    }
}
