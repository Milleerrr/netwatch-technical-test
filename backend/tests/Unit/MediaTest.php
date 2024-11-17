<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Media;
use App\Models\Genre;
use App\Models\Comment;
use App\Models\User;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test media creation.
     */
    public function test_media_movie_can_be_created()
    {
        $media = Media::factory()->create([
            'type' => 'movie',
            'title' => 'Inception',
            'overview' => 'A mind-bending thriller about dream infiltration.',
            'popularity' => 95.5,
            'vote_average' => 8.7,
            'vote_count' => 10000,
            'cast' => json_encode([
                ['name' => 'Leonardo DiCaprio', 'character' => 'Cobb'],
                ['name' => 'Joseph Gordon-Levitt', 'character' => 'Arthur'],
            ]),
        ]);

        $this->assertDatabaseHas('media', [
            'title' => 'Inception',
            'type' => 'movie',
        ]);
    }

    public function test_media_tv_show_can_be_created()
    {
        $media = Media::factory()->create([
            'type' => 'tv_show',
            'title' => 'Breaking Bad',
            'overview' => 'A Chemistry school teacher enters the drug trade.',
            'popularity' => 99.5,
            'vote_average' => 9.5,
            'vote_count' => 1000,
            'cast' => json_encode([
                ['name' => 'Aaron Paul', 'character' => 'Jesse Pinkman'],
                ['name' => 'Bryan Cranston', 'character' => 'Walter White'],
            ]),
        ]);

        $this->assertDatabaseHas('media', [
            'title' => 'Breaking Bad',
            'type' => 'tv_show',
        ]);
    }

    /**
     * Test media relationships with genres.
     */
    public function test_media_can_have_genres()
    {
        $media = Media::factory()->create();
        $genre = Genre::factory()->create(['name' => 'Sci-Fi']);

        $media->genres()->attach($genre);

        $this->assertTrue($media->genres->contains($genre));
    }

    /**
     * Test media relationships with comments.
     */
    public function test_media_can_have_comments()
    {
        $media = Media::factory()->create();
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'media_id' => $media->id,
            'user_id' => $user->id,
            'content' => 'Amazing movie!',
        ]);

        $this->assertTrue($media->comments->contains($comment));
    }

    /**
     * Test fetching the latest comments for media.
     */
    public function test_media_fetches_latest_comments()
    {
        $media = Media::factory()->create();
        $user = User::factory()->create();

        $comments = Comment::factory()->count(10)->create([
            'media_id' => $media->id,
            'user_id' => $user->id,
        ]);

        $latestComments = $media->comments()->orderByDesc('id')->take(5)->get();

        $this->assertCount(5, $latestComments);
        $this->assertEquals($comments->last()->id, $latestComments->first()->id);
    }

    /**
     * Test media can be updated.
     */
    public function test_media_can_be_updated()
    {
        $media = Media::factory()->create([
            'title' => 'Original Title',
        ]);

        $media->update(['title' => 'Updated Title']);

        $this->assertDatabaseHas('media', [
            'id' => $media->id,
            'title' => 'Updated Title',
        ]);
    }

    /**
     * Test media can be deleted.
     */
    public function test_media_can_be_deleted()
    {
        $media = Media::factory()->create();

        $media->delete();

        $this->assertDatabaseMissing('media', [
            'id' => $media->id,
        ]);
    }

    /**
     * Test media has the correct data structure.
     */
    public function test_media_has_correct_data_structure()
    {
        $media = Media::factory()->create([
            'type' => 'movie',
            'title' => 'Avatar',
            'overview' => 'A visually stunning sci-fi adventure.',
            'popularity' => 88.8,
            'vote_average' => 7.8,
            'vote_count' => 1500,
        ]);

        $this->assertEquals('movie', $media->type);
        $this->assertEquals('Avatar', $media->title);
        $this->assertEquals(88.8, $media->popularity);
    }
}
