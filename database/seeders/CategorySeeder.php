<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            // EXTERNAL AND INTERNAL TRANSFER
            [
                'icon' => 'https://ui-avatars.com/api/?name=Internal+Transfer&background=eee&color=000',
                'name' => 'Internal Transfer',
                'slug' => 'internal-transfer',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Transfer&background=00624f&color=fff',
                'name' => 'Transfer',
                'slug' => 'transfer',
            ],

            // ===== EXPENSE CATEGORIES =====
            [
                'icon' => 'https://ui-avatars.com/api/?name=Food&background=FF6B6B&color=fff',
                'name' => 'Food',
                'slug' => 'food',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Drink&background=FFA07A&color=fff',
                'name' => 'Drink',
                'slug' => 'drink',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Transport&background=E17055&color=fff',
                'name' => 'Transport',
                'slug' => 'transport',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Internet&background=6C5CE7&color=fff',
                'name' => 'Internet',
                'slug' => 'internet',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Electricity&background=FFC312&color=fff',
                'name' => 'Electricity',
                'slug' => 'electricity',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Shopping&background=00CEC9&color=fff',
                'name' => 'Shopping',
                'slug' => 'shopping',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Health&background=FF7675&color=fff',
                'name' => 'Health',
                'slug' => 'health',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Subscription&background=F39C12&color=fff',
                'name' => 'Subscription',
                'slug' => 'subscription',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Rent&background=8E44AD&color=fff',
                'name' => 'Rent',
                'slug' => 'rent',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Charity&background=00B894&color=fff',
                'name' => 'Charity',
                'slug' => 'charity',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Education&background=16A085&color=fff',
                'name' => 'Education',
                'slug' => 'education',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Pet&background=FAD02E&color=333',
                'name' => 'Pet',
                'slug' => 'pet',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Other&background=636e72&color=fff',
                'name' => 'Other',
                'slug' => 'other',
            ],

            // ===== INCOME CATEGORIES =====
            [
                'icon' => 'https://ui-avatars.com/api/?name=Salary&background=55EFC4&color=333',
                'name' => 'Salary',
                'slug' => 'salary',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Freelance&background=48C9B0&color=fff',
                'name' => 'Freelance',
                'slug' => 'freelance',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Investment&background=81ECEC&color=333',
                'name' => 'Investment',
                'slug' => 'investment',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Gift&background=FAB1A0&color=333',
                'name' => 'Gift',
                'slug' => 'gift',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Bonus&background=74B9FF&color=fff',
                'name' => 'Bonus',
                'slug' => 'bonus',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Sale&background=E84393&color=fff',
                'name' => 'Sale',
                'slug' => 'sale',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Refund&background=00B8D4&color=fff',
                'name' => 'Refund',
                'slug' => 'refund',
            ],
            [
                'icon' => 'https://ui-avatars.com/api/?name=Reimbursement&background=D63031&color=fff',
                'name' => 'Reimbursement',
                'slug' => 'reimbursement',
            ],
        ]);
    }
}
