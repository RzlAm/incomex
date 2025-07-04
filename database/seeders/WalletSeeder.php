<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wallet::insert([
            ['name' => "BRI"],
            ['name' => "Dana"],
            ['name' => "Dompet"],
        ]);
    }
}
