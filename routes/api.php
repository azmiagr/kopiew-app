<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\PhotoController;
use App\Http\Controllers\Api\PlaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/daftar', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/places', [PlaceController::class, 'store']);
    Route::delete('/place/{place}', [PlaceController::class, 'destroy']);
    Route::put('/place/{place}', [PlaceController::class, 'update']);
    
    Route::post('/place/{id_place}/photo', [PhotoController::class, 'store']);
    Route::patch('/place/{id_place}/photo/{id}', [PhotoController::class, 'update']);
    Route::delete('/place/{id_place}/photo/{id}', [PhotoController::class, 'destroy']);
});

Route::get('/places', [PlaceController::class, 'index']);
Route::get('/place/{place}', [PlaceController::class, 'show']);

Route::get('/place/{id_place}/photos', [PhotoController::class, 'index']);
Route::get('/place/{id_place}/photo/{id}', [PhotoController::class, 'show']);