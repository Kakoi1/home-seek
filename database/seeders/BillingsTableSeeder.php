<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillingsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('billings')->insert([
            [
                'id' => 29,
                'user_id' => 69,
                'rent_form_id' => 54,
                'amount' => 14000.00,
                'billing_date' => '2024-11-30',
                'status' => 'paid',
                'reference' => 'Proof_of_Payment/aazV4wQ7yh3M4bTbA6BA0npJr.jpg',
                'mode' => 'e_wallet',
                'paid_at' => '2024-11-21 04:24:53',
                'created_at' => '2024-11-20 20:14:01',
                'updated_at' => '2024-11-20 20:24:54',
            ],
            // Add all other billings here...
        ]);
    }
}