<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            DormsTableSeeder::class,
            RentFormsTableSeeder::class,
            BillingsTableSeeder::class,
            NotificationsTableSeeder::class,
            FavoritesTableSeeder::class,
            PropertyViewsTableSeeder::class,
            ReviewsTableSeeder::class,
            VerificationsTableSeeder::class,
            ReportsTableSeeder::class,
            CurseWordsTableSeeder::class,
            WalletsTableSeeder::class,
            WalletTransactionsTableSeeder::class,
        ]);
    }
}
