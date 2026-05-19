<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UtilisateurController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profil', [UtilisateurController::class, 'profil']);


    Route::middleware('admin')->group(function () {
        Route::post('/register-admin', [AuthController::class, 'registerAdmin']);
        Route::apiResource('utilisateurs', UtilisateurController::class);
    });
});
