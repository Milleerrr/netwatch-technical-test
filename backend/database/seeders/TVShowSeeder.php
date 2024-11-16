<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Ensure DB is imported
use App\Models\TVShow;
use App\Models\Comment;
use App\Models\Category;

class TVShowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        TVShow::factory(5)->create()->each(function ($tvShow) {
            // Assign 1 random category
            $categories = Category::inRandomOrder()->take(1)->pluck('id');
            $tvShow->categories()->attach($categories);

            // Create and link 5 comments to the TV show
            for ($i = 0; $i < 5; $i++) {
                // Create a new comment in the comments table
                $comment = Comment::factory()->create([
                    'comment_text' => fake()->sentence(),
                    'user_id' => \App\Models\User::inRandomOrder()->first()->id, // Assign a random user
                ]);

                // Insert into the pivot table tv_show_comment
                DB::table('tv_show_comment')->insert([
                    'tv_show_id' => $tvShow->id,
                    'comment_id' => $comment->id,
                ]);
            }
        });
    }
}
