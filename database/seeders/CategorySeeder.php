<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Beverages',
                'description' => 'Drinks, juices, sodas, water, and other beverages',
                'is_active' => true,
            ],
            [
                'name' => 'Snacks',
                'description' => 'Chips, crackers, cookies, nuts, and other snack items',
                'is_active' => true,
            ],
            [
                'name' => 'Canned Goods',
                'description' => 'Canned vegetables, fruits, meats, soups, and sauces',
                'is_active' => true,
            ],
            [
                'name' => 'Frozen Foods',
                'description' => 'Frozen meals, vegetables, ice cream, and frozen treats',
                'is_active' => true,
            ],
            [
                'name' => 'Household Products',
                'description' => 'Cleaning supplies, paper goods, and household essentials',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}
