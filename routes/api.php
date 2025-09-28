<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\api\PhotoController;
use App\Http\Controllers\Api\PlaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WishlistController;

Route::post('/daftar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/place/{place}/reviews', [ReviewController::class, 'show']);



Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
  
  
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/place/{place}/reviews', [ReviewController::class, 'store']);
    Route::put('/place/{place}/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/place/{place}/reviews/{review}', [ReviewController::class, 'destroy']);

    Route::get('/wishlists', [WishlistController::class, 'index']);
    Route::get('/wishlists/{wishlist}', [WishlistController::class, 'show']);
    Route::post('/wishlists', [WishlistController::class, 'store']);
    Route::put('/wishlists/{wishlist}', [WishlistController::class, 'update']);
    Route::patch('/wishlists/{wishlist}', [WishlistController::class, 'update']);
    Route::delete('/wishlists/{wishlist}', [WishlistController::class, 'destroy']);
  
    Route::post('/place', [PlaceController::class, 'store']);
    Route::delete('/place/{place}', [PlaceController::class, 'destroy']);
    Route::put('/place/{place}', [PlaceController::class, 'update']);
    
    Route::post('/place/{id_place}/photos', [PhotoController::class, 'store']);
    Route::patch('/place/{id_place}/photos/{id}', [PhotoController::class, 'update']);
    Route::delete('/place/{id_place}/photos/{id}', [PhotoController::class, 'destroy']);
});

Route::get('/place', [PlaceController::class, 'index']);
Route::get('/place/{place}', [PlaceController::class, 'show']);

Route::get('/place/{id_place}/photos', [PhotoController::class, 'index']);
Route::get('/place/{id_place}/photos/{id}', [PhotoController::class, 'show']);