<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraphs(4, true),
            'featured_image' => sprintf(
                'https://picsum.photos/id/%d/800/600',
                $this->faker->numberBetween(1, 1000)
            ),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
        ];
    }
}
