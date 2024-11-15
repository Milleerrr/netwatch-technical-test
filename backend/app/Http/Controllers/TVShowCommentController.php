<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\TVShow;
use Illuminate\Http\Request;

class TVShowCommentController extends Controller
{
    /**
     * Display a listing of comments for a specific TV show.
     */
    public function index(TVShow $tvShow)
    {
        // Return all comments for the given TV show, including the user who posted them
        return response()->json($tvShow->comments()->with('user')->get());
    }

    /**
     * Store a newly created comment for a specific TV show in the database.
     */
    public function store(Request $request, TVShow $tvShow)
    {
        // Validate input data
        $validated = $request->validate([
            'comment_text' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        // Create a new comment
        $comment = Comment::create($validated);

        // Attach the comment to the TV show
        $tvShow->comments()->attach($comment->id);

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
