<?php

use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\CarLikeController;
use App\Http\Middleware\EnsureIsAdmin;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);

    Route::get('/cars', [CarController::class, 'index']);
    Route::get('/cars/{car}', [CarController::class, 'show']);

    Route::get('/user/preferences', [CarLikeController::class, 'index']);
    Route::post('/cars/{car}/like', [CarLikeController::class, 'store']);
    Route::delete('/cars/{car}/like', [CarLikeController::class, 'destroy']);

    Route::middleware(EnsureIsAdmin::class)->prefix('admin')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index']);
        Route::get('/users/{user}', [AdminUserController::class, 'show']);

        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/reports/{user}', [ReportController::class, 'show']);
    });
});
