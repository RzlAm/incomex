<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Wallet::insert([
            [
                'name' => "BRI"
            ],
            [
                'name' => "Dana"
            ],
            [
                'name' => "Dompet"
            ],
        ]);

        $this->call([
            CategorySeeder::class,
            SettingSeeder::class,
        ]);
    }
}
