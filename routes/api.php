<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔥 UPDATE TERPISAH
Route::post('/update-alamat', [UserController::class, 'updateAlamat']);
Route::post('/update-nohp', [UserController::class, 'updateNoHp']);
Route::get('/profile', [UserController::class, 'getProfile']);
Route::post('/update-foto', [UserController::class, 'updateFoto']);

// CORS
Route::options('{any}', function () {
    return response()->json([], 200);
})->where('any', '.*');
