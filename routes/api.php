<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CollegeMajorController;
use App\Http\Controllers\MajorCollegeController;
use App\Http\Controllers\MajorController;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Orion::resource('colleges', CollegeController::class)->withSoftDeletes();
    Orion::hasManyResource('colleges', 'majors', CollegeMajorController::class);

    Orion::resource('majors', MajorController::class);
    Orion::belongsToResource('majors', 'college', MajorCollegeController::class)->withSoftDeletes();
});
