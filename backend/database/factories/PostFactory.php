<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraph(),
            'views' => $this->faker->numberBetween(0, 100),
            'start_at' => now()->subDays(rand(0, 5)),
            'end_at' => now()->addDays(rand(0, 5)),
        ];
    }
}
