<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        // Return all categories
        return response()->json(Category::all());
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        // Return data necessary for creating a category (if needed)
        return response()->json(); // This can be empty or customized
    }

    /**
     * Store a newly created category in the database.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        // Create a new category
        $category = Category::create($validated);

        // Return the created category
        return response()->json($category, 201);
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        // Return the category
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        // Return the category data for editing
        return response()->json($category);
    }

    /**
     * Update the specified category in the database.
     */
    public function update(Request $request, Category $category)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // Update the category
        $category->update($validated);

        // Return the updated category
        return response()->json($category);
    }

    /**
     * Remove the specified category from the database.
     */
    public function destroy(Category $category)
    {
        // Delete the category
        $category->delete();

        // Return a no-content response
        return response()->json(null, 204);
    }
}
