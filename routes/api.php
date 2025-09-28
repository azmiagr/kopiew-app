<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/daftar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/place/{place}/reviews', [ReviewController::class, 'show']);



Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/place/{place}/reviews', [ReviewController::class, 'store']);
    Route::put('/place/{place}/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/place/{place}/reviews/{review}', [ReviewController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
