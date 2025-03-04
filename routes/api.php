<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\MajorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('majors', MajorController::class, ['except' => ['update']])->middleware('admin');
    Route::patch('/majors/{major}', [MajorController::class, 'update'])->middleware('admin');

    Orion::resource('colleges', CollegeController::class);
});

Route::get('/user', function (Request $request) {

    return $request->user();
})->middleware('auth:sanctum');
