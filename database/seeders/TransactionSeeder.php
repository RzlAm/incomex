<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallets = Wallet::all();
        $categories = Category::all();

        foreach ($wallets as $wallet) {
            $start = now()->subMonths(12);
            $end = now();

            // Seed transaksi per bulan untuk setiap dompet
            while ($start < $end) {
                $transactions = [];

                // 60% income, 40% expense (per wallet)
                for ($i = 0; $i < rand(10, 30); $i++) {
                    $isIncome = fake()->boolean(60);
                    $amount = $isIncome
                        ? fake()->randomFloat(2, 100000, 300000)  // income agak besar
                        : fake()->randomFloat(2, 10000, 200000);  // expense lebih kecil

                    $date = fake()->dateTimeBetween($start, $start->copy()->endOfMonth());

                    $transactions[] = [
                        'wallet_id' => $wallet->id,
                        'category_id' => $categories->random()->id,
                        'date_time' => $date,
                        'type' => $isIncome ? 'income' : 'expense',
                        'amount' => $amount,
                        'description' => fake()->sentence(),
                        'created_at' => $date,
                        'updated_at' => $date,
                    ];
                }

                Transaction::insert($transactions);
                $start->addMonth();
            }

            // Kasih saldo awal gede biar aman
            Transaction::create([
                'wallet_id' => $wallet->id,
                'category_id' => $categories->random()->id,
                'date_time' => now()->subYears(1),
                'type' => 'income',
                'amount' => 10_000_000,
                'description' => 'Initial Balance',
            ]);
        }
    }
}
