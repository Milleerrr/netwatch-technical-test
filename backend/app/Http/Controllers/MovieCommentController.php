<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieCommentController extends Controller
{
    /**
     * Display a listing of comments for a specific movie.
     */
    public function index(Movie $movie)
    {
        // Return all comments for the given movie, including the user who posted them
        return response()->json($movie->comments()->with('user')->get());
    }

    /**
     * Store a newly created comment for a specific movie in the database.
     */
    public function store(Request $request, Movie $movie)
    {
        // Validate input data
        $validated = $request->validate([
            'comment_text' => 'required|string',
            'user_id' => 'required|exists:users,id', // Ensure user exists
        ]);

        // Create a new comment
        $comment = Comment::create($validated);

        // Attach the comment to the movie
        $movie->comments()->attach($comment->id);

        // Return the created comment
        return response()->json($comment, 201);
    }

    /**
     * Display the specified comment.
     */
    public function show(Comment $comment)
    {
        // Return the comment with the user who posted it
        return response()->json($comment->load('user'));
    }

    /**
     * Update the specified comment in the database.
     */
    public function update(Request $request, Comment $comment)
    {
        // Validate input data
        $validated = $request->validate([
            'comment_text' => 'required|string',
        ]);

        // Update the comment
        $comment->update($validated);

        // Return the updated comment
        return response()->json($comment);
    }

    /**
     * Remove the specified comment from the database.
     */
    public function destroy(Comment $comment)
    {
        // Delete the comment
        $comment->delete();

        // Return a no-content response
        return response()->json(null, 204);
    }
}
