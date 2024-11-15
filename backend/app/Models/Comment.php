<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['comment_text', 'user_id'];

    /**
     * Get the user who wrote the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the TV shows this comment belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<TVShow>
     */
    public function tvShows(): BelongsToMany
    {
        return $this->belongsToMany(TVShow::class, 'tv_show_comment');
    }

    /**
     * Get the movies this comment belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Movie>
     */
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'movie_comment');
    }
}
