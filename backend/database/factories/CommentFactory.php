<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Media;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->sentence, // Random comment content
            'user_id' => User::factory(),        // Create or use a user
            'media_id' => Media::factory(),      // Create or use a media item
            'likes' => $this->faker->numberBetween(0, 100), // Random number of likes
        ];
    }
}
