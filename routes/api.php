<?php

use App\Http\Controllers\Api\AuthController;
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

});
