<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('wallets')->insert([
            [
                'id' => 1,
                'user_id' => 69,
                'balance' => 10100.00,
                'created_at' => '2024-11-24 01:53:19',
                'updated_at' => '2024-11-26 19:53:59',
            ],
            [
                'id' => 2,
                'user_id' => 70,
                'balance' => 1400.00,
                'created_at' => '2024-11-25 01:16:52',
                'updated_at' => '2024-12-01 23:09:31',
            ],
            [
                'id' => 8,
                'user_id' => 71,
                'balance' => 2000.00,
                'created_at' => '2024-11-28 03:27:08',
                'updated_at' => '2024-11-27 20:52:24',
            ],
            [
                'id' => 9,
                'user_id' => 68,
                'balance' => 8000.00,
                'created_at' => '2024-11-28 04:55:11',
                'updated_at' => '2024-11-27 20:58:00',
            ],
        ]);
    }
}