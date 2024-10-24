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


        }


    }
}
