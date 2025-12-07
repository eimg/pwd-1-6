<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        if ($posts->isEmpty()) {
            $posts = Post::factory()->count(5)->create();
        }

        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory()->count(3)->create();
        }

        Comment::factory()
            ->count(40)
            ->state(new Sequence(fn () => [
                'post_id' => $posts->random()->id,
                'user_id' => $users->random()->id,
            ]))
            ->create();
    }
}
