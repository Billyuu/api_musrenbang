<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UsulanController; // 🔥 Import controller baru

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//UPDATE TERPISAH
Route::post('/update-alamat', [UserController::class, 'updateAlamat']);
Route::post('/update-nohp', [UserController::class, 'updateNoHp']);
Route::get('/profile', [UserController::class, 'getProfile']);
Route::post('/update-foto', [UserController::class, 'updateFoto']);

//ROUTE KHUSUS USULAN MUSRENBANG
// Untuk mengirim usulan baru
Route::post('/usulan', [UsulanController::class, 'store']);
// Untuk melihat daftar usulan milik user tertentu
Route::get('/usulan/{user_id}', [UsulanController::class, 'index']);

//CORS
Route::options('{any}', function () {
    return response()->json([], 200);
})->where('any', '.*');