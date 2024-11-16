<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Comment;
use App\Models\User;
use App\Models\Media;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        // Number of comments per media item
        $commentsPerMedia = 10;

        // Get all media items
        $mediaItems = Media::all();

        // Get all user IDs
        $userIds = User::pluck('id')->toArray();

        // Fetch all available comments from the API (30 comments)
        $apiUrl = 'https://dummyjson.com/comments';
        $response = Http::get($apiUrl, [
            'limit' => 30, // The API provides 30 comments
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $commentsFetched = $data['comments'];
        } else {
            $this->command->error('Failed to fetch comments from the API.');
            return;
        }

        // Iterate over each media item
        foreach ($mediaItems as $media) {
            for ($i = 0; $i < $commentsPerMedia; $i++) {
                // Pick a random comment from the fetched comments
                $apiComment = $commentsFetched[array_rand($commentsFetched)];

                $content = $apiComment['body'] ?? 'No content';
                $likes = $apiComment['likes'] ?? rand(0, 100);

                // Optionally, add a slight variation to the comment to reduce exact duplicates
                $variation = rand(1, 1000);
                $contentWithVariation = $content . ' #' . $variation;

                // Assign a random user ID
                $userId = $userIds[array_rand($userIds)];

                // Create the comment
                Comment::create([
                    'content'   => $contentWithVariation,
                    'likes'     => $likes,
                    'user_id'   => $userId,
                    'media_id'  => $media->id,
                ]);

                // Print statement after inserting each comment
                $this->command->info("Inserted comment for media: {$media->title}");
            }
        }
    }
}
