<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CollegeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('colleges', CollegeController::class, ['except' => ['update']]);
    Route::patch('/colleges/{college}', [CollegeController::class, 'update']);
});

Route::get('/user', function (Request $request) {

    return $request->user();
})->middleware('auth:sanctum');
