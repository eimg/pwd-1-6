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
        $categories = [
            'Technology',
            'Lifestyle',
            'Travel',
            'Food',
            'Business',
        ];

        foreach ($categories as $name) {
            Category::query()->firstOrCreate([
                'name' => $name,
            ]);
        }
    }
}
