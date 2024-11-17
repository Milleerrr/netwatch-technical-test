<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the media items.
     */
    public function index(Request $request)
    {
        // Get the 'type' parameter from the query string
        $type = $request->query('type');

        // Build the query
        $query = Media::with('genres');

        // If 'type' is provided and valid, add a where clause
        if ($type && in_array($type, ['movie', 'tv_show'])) {
            $query->where('type', $type);
        }

        // Get the media items
        $mediaItems = $query->get();

        // Return the media items
        return response()->json($mediaItems);
    }

    /**
     * Store a newly created media item in the database.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'type'          => 'required|string|in:movie,tv_show',
            'title'         => 'required|string|max:255',
            'overview'      => 'nullable|string',
            'popularity'    => 'nullable|numeric',
            'image'         => 'nullable|url',
            'vote_average'  => 'nullable|numeric',
            'vote_count'    => 'nullable|integer',
            'cast'          => 'nullable|array',
            'genres'        => 'nullable|array', // Expecting an array of genre IDs
        ]);

        // Create a new media item
        $media = Media::create($validated);

        // Attach genres if provided
        if (!empty($validated['genres'])) {
            $media->genres()->attach($validated['genres']);
        }

        // Return the created media item with genres
        return response()->json($media->load('genres'), 201);
    }

    /**
     * Display the specified media item.
     */
    public function show(Media $mediaId)
    {
        $mediaId->load(['genres', 'latestComments.user']);
        return response()->json($mediaId);
    }

    /**
     * Update the specified media item in the database.
     */
    public function update(Request $request, Media $media)
    {
        // Validate input data
        $validated = $request->validate([
            'type'          => 'sometimes|string|in:movie,tv_show',
            'title'         => 'sometimes|string|max:255',
            'overview'      => 'nullable|string',
            'popularity'    => 'nullable|numeric',
            'image'         => 'nullable|url',
            'vote_average'  => 'nullable|numeric',
            'vote_count'    => 'nullable|integer',
            'cast'          => 'nullable|array',
            'genres'        => 'nullable|array', // Expecting an array of genre IDs
        ]);

        // Update the media item
        $media->update($validated);

        // Sync genres if provided
        if ($request->has('genres')) {
            $media->genres()->sync($validated['genres']);
        }

        // Return the updated media item with genres
        return response()->json($media->load('genres'));
    }

    /**
     * Remove the specified media item from the database.
     */
    public function destroy(Media $media)
    {
        // Delete the media item
        $media->delete();

        // Return a no-content response
        return response()->json(null, 204);
    }
}
