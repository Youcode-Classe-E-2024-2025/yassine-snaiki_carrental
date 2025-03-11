<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::name('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::name('user')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    Route::name('car')->group(function () {
        Route::post('/cars', [CarController::class, 'store']);
        Route::put('/cars/{car}', [CarController::class, 'update']);
        Route::patch('/cars/{car}', [CarController::class, 'patch']);
        Route::delete('/cars/{id}', [CarController::class, 'destroy']);
    });
    Route::name('payment')->group(function () {
        Route::post('/payments', [CarController::class, 'store']);
        Route::get('/payments', [CarController::class, 'store']);
        Route::get('/payments/{user}', [CarController::class, 'store']);
        Route::get('/payments/{rental}', [CarController::class, 'store']);
        Route::get('/payments/{payment}', [CarController::class, 'store']);

    });
});

Route::name('car')->group(function () {
Route::get('/cars', [CarController::class, 'index']);
Route::get('/cars/{car}', [CarController::class, 'show']);
});
