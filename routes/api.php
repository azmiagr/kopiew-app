<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ThreadController;

// ---------------- AUTH ----------------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ---------------- PUBLIC PLACE & REVIEW ----------------
Route::get('/place', [PlaceController::class, 'index']);
Route::get('/place/{place}', [PlaceController::class, 'show']);
Route::get('/place/{place}/reviews', [ReviewController::class, 'show']);
Route::get('/reviews', [ReviewController::class, 'index']);

// ---------------- PUBLIC PHOTO ----------------
Route::get('/place/{place}/photos', [PhotoController::class, 'index']);
Route::get('/place/{place}/photos/{photo}', [PhotoController::class, 'show']);

// ---------------- THREADS (optional fitur forum) ----------------
Route::get('/threads', [ThreadController::class, 'index']);
Route::get('/threads/{thread}', [ThreadController::class, 'show']);

// ---------------- PROTECTED ROUTES ----------------
Route::middleware('auth:api')->group(function () {
    // AUTH
    Route::post('/logout', [AuthController::class, 'logout']);

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::patch('/profile/photo', [ProfileController::class, 'photoUpload']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    // PLACE
    Route::post('/place', [PlaceController::class, 'store']);
    Route::put('/place/{place}', [PlaceController::class, 'update']);
    Route::delete('/place/{place}', [PlaceController::class, 'destroy']);

    // REVIEW
    Route::post('/place/{place}/reviews', [ReviewController::class, 'store']);
    Route::put('/place/{place}/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/place/{place}/reviews/{review}', [ReviewController::class, 'destroy']);

    // COMMENT 
    Route::prefix('place/{place}/reviews/{review}')->group(function () {
        Route::get('/comments', [CommentController::class, 'index']);
        Route::post('/comments', [CommentController::class, 'store']);
        Route::put('/comments/{comment}', [CommentController::class, 'update']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    });

    // PHOTO
    Route::post('/place/{place}/photos', [PhotoController::class, 'store']);
    Route::put('/place/{place}/photos/{photo}', [PhotoController::class, 'update']);
    Route::delete('/place/{place}/photos/{photo}', [PhotoController::class, 'destroy']);

    // WISHLIST
    Route::get('/wishlists', [WishlistController::class, 'index']);
    Route::get('/wishlists/{wishlist}', [WishlistController::class, 'show']);
    Route::post('/wishlists', [WishlistController::class, 'store']);
    Route::put('/wishlists/{wishlist}', [WishlistController::class, 'update']);
    Route::delete('/wishlists/{wishlist}', [WishlistController::class, 'destroy']);

    // THREADS 
    Route::post('/threads', [ThreadController::class, 'store']);
    Route::put('/threads/{thread}', [ThreadController::class, 'update']);
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy']);
    Route::post('/threads/{thread}/like', [ThreadController::class, 'like']);
    Route::post('/threads/{thread}/comments', [ThreadController::class, 'addComment']);
});
