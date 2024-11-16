<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
     * Store a newly created user in the database.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users',
            'password'    => 'required|string|min:8|confirmed',
            'profile_pic' => 'nullable|url',
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

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
        // Optionally load the user's comments
        // $user->load('comments');

        // Return the user
        return response()->json($user);
    }

    /**
     * Update the specified user in the database.
     */
    public function update(Request $request, User $user)
    {
        // Validate input data
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'email'       => 'sometimes|email|unique:users,email,' . $user->id,
            'password'    => 'sometimes|nullable|string|min:8|confirmed',
            'profile_pic' => 'sometimes|nullable|url',
        ]);

        // Hash the password if it's set
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

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
