<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['movie', 'tv_show']),
            'title' => $this->faker->sentence,
            'overview' => $this->faker->paragraph,
            'popularity' => $this->faker->randomFloat(2, 0, 100),
            'image' => $this->faker->imageUrl(),
            'vote_average' => $this->faker->randomFloat(1, 1, 10),
            'vote_count' => $this->faker->numberBetween(0, 5000),
            'cast' => json_encode([
                ['name' => $this->faker->name, 'character' => $this->faker->word],
            ]),
        ];
    }
}
