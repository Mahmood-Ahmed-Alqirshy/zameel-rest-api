<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CollegeMajorController;
use App\Http\Controllers\MajorCollegeController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Orion::resource('colleges', CollegeController::class)->withSoftDeletes();
    Orion::hasManyResource('colleges', 'majors', CollegeMajorController::class)->withSoftDeletes();

    Orion::resource('majors', MajorController::class)->withSoftDeletes();
    Orion::belongsToResource('majors', 'college', MajorCollegeController::class)->withSoftDeletes();

    Orion::resource('subjects', SubjectController::class)->withSoftDeletes();
});
