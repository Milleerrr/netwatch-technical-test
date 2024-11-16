<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Media;
use App\Models\Genre;

class MediaTableSeeder extends Seeder
{
    public function run()
    {

        Media::truncate();
        // Define the number of media items you want to fetch
        $numberOfMediaItems = 40; // Adjust the number as needed

        // API endpoint to fetch media items
        $apiUrl = "https://jsonfakery.com/movies/random/{$numberOfMediaItems}";

        // Fetch data from the API
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $mediaDataList = $response->json();

            // Calculate half of the total number of media items
            $halfCount = intval(count($mediaDataList) / 2);

            $counter = 0;

            foreach ($mediaDataList as $mediaData) {
                try {
                    $counter++;

                    // Determine the 'type' based on the counter
                    $type = ($counter <= $halfCount) ? 'movie' : 'tv_show';

                    // Map the API data to your media table fields
                    $media = Media::create([
                        'type'          => $type,
                        'title'         => $mediaData['original_title'],
                        'overview'      => $mediaData['overview'] ?? '',
                        'popularity'    => $mediaData['popularity'] ?? 0,
                        'image'         => $mediaData['poster_path'] ?? '',
                        'vote_average'  => $mediaData['vote_average'] ?? 0,
                        'vote_count'    => $mediaData['vote_count'] ?? 0,
                        'cast'          => $mediaData['casts'] ?? [],
                    ]);

                    // Randomly assign genres to the media item
                    $genreIds = Genre::inRandomOrder()->take(rand(1, 3))->pluck('id');
                    $media->genres()->attach($genreIds);

                    // Print statement after inserting each media item
                    $this->command->info("Inserted media item: {$media->title} as {$type}");
                } catch (\Exception $e) {
                    $this->command->error('Error creating media item: ' . $e->getMessage());
                }
            }
        } else {
            $this->command->error('Failed to fetch media items from the API.');
        }
    }
}