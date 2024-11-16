<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of movies.
     */
    public function index()
    {
        // Return all movies with their associated categories and comments
        return response()->json(Movie::with('categories', 'comments')->get());
    }

    /**
     * Show the form for creating a new movie.
     */
    public function create()
    {
        // Return necessary data for creating a movie, such as available categories
        return response()->json(['categories' => Category::all()]);
    }

    /**
     * Store a newly created movie in the database.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'categories' => 'array|required', // Expect an array of category IDs
        ]);

        // Create the movie
        $movie = Movie::create($validated);

        // Attach categories to the movie
        $movie->categories()->attach($validated['categories']);

        // Return the created movie
        return response()->json($movie, 201);
    }

    /**
     * Display a specific movie.
     */
    public function show(Movie $movie)
    {
        // Return the movie with its categories and comments
        return response()->json($movie->load('categories', 'comments'));
    }

    /**
     * Show the form for editing a specific movie.
     */
    public function edit(Movie $movie)
    {
        // Return the movie and all available categories for editing
        return response()->json([
            'movie' => $movie->load('categories'),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update a specific movie in the database.
     */
    public function update(Request $request, Movie $movie)
    {
        // Validate input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
        ]);

        // Update the movie
        $movie->update($validated);

        // Return the updated movie
        return response()->json($movie);
    }

    /**
     * Remove a specific movie from the database.
     */
    public function destroy(Movie $movie)
    {
        // Delete the movie
        $movie->delete();

        // Return a no-content response
        return response()->json(null, 204);
    }
}
