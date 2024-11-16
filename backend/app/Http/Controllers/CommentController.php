<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        // Return all comments with their users and media items
        $comments = Comment::with(['user', 'media'])->get();
        return response()->json($comments);
    }

    /**
     * Store a newly created comment in the database.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'content'   => 'required|string',
            'user_id'   => 'required|exists:users,id',
            'media_id'  => 'required|exists:media,id',
            'likes'     => 'nullable|integer|min:0',
        ]);

        // Create a new comment
        $comment = Comment::create($validated);

        // Return the created comment with user and media
        return response()->json($comment->load(['user', 'media']), 201);
    }

    /**
     * Display the specified comment.
     */
    public function show(Comment $comment)
    {
        // Load the comment's user and media
        $comment->load(['user', 'media']);

        // Return the comment
        return response()->json($comment);
    }

    /**
     * Update the specified comment in the database.
     */
    public function update(Request $request, Comment $comment)
    {
        // Validate input data
        $validated = $request->validate([
            'content'   => 'sometimes|required|string',
            'user_id'   => 'sometimes|required|exists:users,id',
            'media_id'  => 'sometimes|required|exists:media,id',
            'likes'     => 'nullable|integer|min:0',
        ]);

        // Update the comment
        $comment->update($validated);

        // Return the updated comment with user and media
        return response()->json($comment->load(['user', 'media']));
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
