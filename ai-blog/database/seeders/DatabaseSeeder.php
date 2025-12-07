<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Alice Writer',
            'email' => 'alice@example.com',
        ]);

        User::factory()->create([
            'name' => 'Bob Editor',
            'email' => 'bob@example.com',
        ]);

        User::factory(5)->create();

        $this->call([
            CategorySeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
