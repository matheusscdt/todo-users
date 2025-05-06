<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/loginApi', [AuthController::class, 'loginApi']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logoutApi', [AuthController::class, 'logoutApi']);
});

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('users', UserController::class);
});
