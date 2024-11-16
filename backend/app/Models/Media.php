<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'overview',
        'popularity',
        'image',
        'vote_average',
        'vote_count',
        'cast',
    ];

    protected $casts = [
        'cast' => 'array',
    ];

    /**
     * The genres that belong to the media.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'media_genres');
    }

    /**
     * Get the comments for the media.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the latest 5 comments for the media, ordered by id descending.
     */
    public function latestComments()
    {
        return $this->hasMany(Comment::class)
            ->orderBy('id', 'desc')
            ->limit(5);
    }
}
