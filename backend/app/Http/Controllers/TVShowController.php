<?php

namespace App\Http\Controllers;

use App\Models\TVShow;
use App\Models\Category;
use Illuminate\Http\Request;

class TVShowController extends Controller
{
    /**
     * Display a listing of TV shows.
     */
    public function index()
    {
        // Return all TV shows with their associated categories and comments
        return response()->json(TVShow::with('categories', 'comments')->get());
    }

    /**
     * Show the form for creating a new TV show.
     */
    public function create()
    {
        // Return necessary data for creating a TV show, such as available categories
        return response()->json(['categories' => Category::all()]);
    }

    /**
     * Store a newly created TV show in the database.
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

        // Create the TV show
        $tvShow = TVShow::create($validated);

        // Attach categories to the TV show
        $tvShow->categories()->attach($validated['categories']);

        // Return the created TV show
        return response()->json($tvShow, 201);
    }

    /**
     * Display a specific TV show.
     */
    public function show(TVShow $tvShow)
    {
        // Return the TV show with its categories and comments
        return response()->json($tvShow->load('categories', 'comments'));
    }

    /**
     * Show the form for editing a specific TV show.
     */
    public function edit(TVShow $tvShow)
    {
        // Return the TV show and all available categories for editing
        return response()->json([
            'tvShow' => $tvShow->load('categories'),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update a specific TV show in the database.
     */
    public function update(Request $request, TVShow $tvShow)
    {
        // Validate input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'categories' => 'array|required', // Expect an array of category IDs
        ]);

        // Update the TV show
        $tvShow->update($validated);

        // Sync categories with the TV show
        $tvShow->categories()->sync($validated['categories']);

        // Return the updated TV show
        return response()->json($tvShow);
    }

    /**
     * Remove a specific TV show from the database.
     */
    public function destroy(TVShow $tvShow)
    {
        // Delete the TV show
        $tvShow->delete();

        // Return a no-content response
        return response()->json(null, 204);
    }
}
