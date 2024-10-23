<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\MajorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('colleges', CollegeController::class, ['except' => ['update']])->middleware('admin');
    Route::patch('/colleges/{college}', [CollegeController::class, 'update'])->middleware('admin');

    Route::apiResource('majors', MajorController::class, ['except' => ['update']])->middleware('admin');
    Route::patch('/majors/{major}', [MajorController::class, 'update'])->middleware('admin');
});

Route::get('/user', function (Request $request) {

    return $request->user();
})->middleware('auth:sanctum');
