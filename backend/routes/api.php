<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CommentController;

// Routes for the Media
Route::apiResource('media', MediaController::class)->parameters([
    'media' => 'movieId',
]);

// Routes for the Genres
Route::apiResource('genres', GenreController::class);

// Routes for the Comments
Route::apiResource('comments', CommentController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});