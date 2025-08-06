<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-2 years', 'now');

        return [
            'wallet_id'   => \App\Models\Wallet::inRandomOrder()->first()->id ?? 1,
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id ?? 1,
            'date_time'   => $date,
            'type'        => $this->faker->randomElement(['income', 'expense']),
            'amount'      => $this->faker->randomFloat(2, 1000, 1000000),
            'description' => $this->faker->optional()->sentence(),
            'created_at'  => $date,
            'updated_at'  => $date,
        ];
    }
}
