<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Ensure DB is imported
use App\Models\Movie;
use App\Models\Comment;
use App\Models\Category;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Movie::factory(5)->create()->each(function ($movie) {
            // Assign 3 random categories
            $categories = Category::inRandomOrder()->take(3)->pluck('id');
            $movie->categories()->attach($categories);

            // Create and link 5 comments to the movie
            for ($i = 0; $i < 5; $i++) {
                // Create a new comment in the comments table
                $comment = Comment::factory()->create([
                    'comment_text' => fake()->sentence(),
                    'user_id' => \App\Models\User::inRandomOrder()->first()->id, // Assign a random user
                ]);

                // Insert into the pivot table movie_comment
                DB::table('movie_comment')->insert([
                    'movie_id' => $movie->id,
                    'comment_id' => $comment->id,
                ]);
            }
        });
    }
}
