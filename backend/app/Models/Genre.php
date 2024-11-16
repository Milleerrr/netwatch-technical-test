<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * The media that belong to the genre.
     */
    public function media()
    {
        return $this->belongsToMany(Media::class, 'media_genres');
    }
}
