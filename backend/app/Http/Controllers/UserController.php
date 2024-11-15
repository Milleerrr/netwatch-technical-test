<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Return all users
        return response()->json(User::all());
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Return data necessary for creating a user (if needed)
        return response()->json(); // This can be empty or customized
    }

    /**
     * Store a newly created user in the database.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'family_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);

        // Create a new user
        $user = User::create($validated);

        // Return the created user
        return response()->json($user, 201);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Return the user with their related comments
        return response()->json($user->load('comments'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Return the user data for editing
        return response()->json($user);
    }

    /**
     * Update the specified user in the database.
     */
    public function update(Request $request, User $user)
    {
        // Validate input data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'family_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Update the user
        $user->update($validated);

        // Return the updated user
        return response()->json($user);
    }

    /**
     * Remove the specified user from the database.
     */
    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();

        // Return a no-content response
        return response()->json(null, 204);
    }
}
