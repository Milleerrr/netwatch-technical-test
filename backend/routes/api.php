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
use App\Http\Controllers\TVShowController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TVShowCommentController;
use App\Http\Controllers\MovieCommentController;

// Resource routes for TV Shows
Route::resource('tv-shows', TVShowController::class);

// Resource routes for Movies
Route::resource('movies', MovieController::class);

// Resource routes for Users
Route::resource('users', UserController::class);

// Resource routes for Categories
Route::resource('categories', CategoryController::class);

// Routes for TV Show Comments
Route::resource('tv-shows.comments', TVShowCommentController::class)->shallow();

// Routes for Movie Comments
Route::resource('movies.comments', MovieCommentController::class)->shallow();

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});