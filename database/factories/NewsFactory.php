<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'path' => fake()->imageUrl(),
            'isPublished' => fake()->boolean(),
            'news_category_id' => fake()->biasedNumberBetween(1, 3),
            'reading_time' => fake()->biasedNumberBetween(10, 120),
        ];
    }
}
