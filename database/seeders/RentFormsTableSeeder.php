<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentFormsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('rent_forms')->insert([
            [
                'id' => 52,
                'user_id' => 69,
                'dorm_id' => 53,
                'start_date' => '2024-11-23',
                'end_date' => '2024-11-29',
                'guest' => 3,
                'total_price' => 18000.00,
                'status' => 'rejected',
                'note' => 'we are not available',
                'created_at' => '2024-11-20 20:04:24',
                'updated_at' => '2024-11-20 20:05:22',
            ],
            [
                'id' => 53,
                'user_id' => 69,
                'dorm_id' => 54,
                'start_date' => '2024-11-23',
                'end_date' => '2024-11-26',
                'guest' => 4,
                'total_price' => 4000.00,
                'status' => 'cancelled',
                'note' => 'Issue with booking process',
                'created_at' => '2024-11-20 20:06:51',
                'updated_at' => '2024-11-20 20:10:40',
            ],
            // Add all other rent forms here...
        ]);
    }
}