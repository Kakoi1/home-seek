<?php

namespace App\Console\Commands;

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
        $rentForms = RentForm::where('start_date', $today)
            ->where('status', 'approved') // Only approved rent forms
            ->get();

        foreach ($rentForms as $rentForm) {
            // Check if the rent form is short term or long term
            if ($rentForm->term == 'short_term') {
                // Create a billing entry for the full amount (short term)
                Billing::create([
                    'user_id' => $rentForm->user_id,
                    'rent_form_id' => $rentForm->id,
                    'amount' => $rentForm->total_price,
                    'billing_date' => $rentForm->end_date,
                    'status' => 'pending', // Set initial status to pending
                ]);
            } elseif ($rentForm->term == 'long_term') {
                // Calculate the monthly payment
                $monthlyPayment = $rentForm->total_price / $rentForm->duration;

                // Generate billing for each month
                for ($i = 1; $i < $rentForm->duration + 1; $i++) {
                    // Calculate the billing date for each month
                    $billingDate = Carbon::parse($today)->addMonths($i)->toDateString();

                    // Create billing entry for the specific month
                    Billing::create([
                        'user_id' => $rentForm->user_id,
                        'rent_form_id' => $rentForm->id,
                        'amount' => $monthlyPayment,
                        'billing_date' => $billingDate,
                        'status' => 'pending', // Set initial status to pending
                    ]);
                }
            }

            // Optionally update the rent form status
            $rentForm->update([
                'status' => 'active', // Set status to active
            ]);


        }


    }
}
