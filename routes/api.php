<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WishlistController;

Route::post('/daftar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/wishlists', [WishlistController::class, 'index']);
    Route::get('/wishlists/{wishlist}', [WishlistController::class, 'show']);
    Route::post('/wishlists', [WishlistController::class, 'store']);
    Route::put('/wishlists/{wishlist}', [WishlistController::class, 'update']);
    Route::patch('/wishlists/{wishlist}', [WishlistController::class, 'update']);
    Route::delete('/wishlists/{wishlist}', [WishlistController::class, 'destroy']);
  
    Route::post('/place', [PlaceController::class, 'store']);
    Route::delete('/place/{place}', [PlaceController::class, 'destroy']);
    Route::put('/place/{place}', [PlaceController::class, 'update']);
});

Route::get('/place', [PlaceController::class, 'index']);
Route::get('/place/{place}', [PlaceController::class, 'show']);
