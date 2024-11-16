<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the genres.
     */
    public function index()
    {
        // Return all genres with their media items
        $genres = Genre::with('media')->get();
        return response()->json($genres);
    }

    /**
     * Store a newly created genre in the database.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres',
        ]);

        // Create a new genre
        $genre = Genre::create($validated);

        // Return the created genre
        return response()->json($genre, 201);
    }

    /**
     * Display the specified genre.
     */
    public function show(Genre $genre)
    {
        // Load the genre's media items
        $genre->load('media');

        // Return the genre
        return response()->json($genre);
    }

    /**
     * Update the specified genre in the database.
     */
    public function update(Request $request, Genre $genre)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        // Update the genre
        $genre->update($validated);

        // Return the updated genre
        return response()->json($genre);
    }

    /**
     * Remove the specified genre from the database.
     */
    public function destroy(Genre $genre)
    {
        // Delete the genre
        $genre->delete();

        // Return a no-content response
        return response()->json(null, 204);
    }
}
