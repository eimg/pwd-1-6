<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            $categories = Category::factory()->count(3)->create();
        }

        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory()->count(3)->create();
        }

        Post::factory()
            ->count(15)
            ->state(new Sequence(fn () => [
                'category_id' => $categories->random()->id,
                'user_id' => $users->random()->id,
            ]))
            ->create();
    }
}
