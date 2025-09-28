<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;

Route::post('/daftar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/threads', [ThreadController::class, 'index']);
    Route::post('/threads', [ThreadController::class, 'store']);
    Route::get('/threads/{thread}', [ThreadController::class, 'show']);
    Route::put('/threads/{thread}', [ThreadController::class, 'update']);
    Route::patch('/threads/{thread}', [ThreadController::class, 'update']);
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy']);

    Route::post('/threads/{thread}/like', [ThreadController::class, 'like']);
    Route::post('/threads/{thread}/comments', [ThreadController::class, 'addComment']);
});
