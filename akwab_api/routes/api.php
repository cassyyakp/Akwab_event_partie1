<?php

use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UtilisateurController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/categories', [CategorieController::class, 'index']);
Route::get('/categories/{id}', [CategorieController::class, 'show']);

Route::get('/evenements', [EvenementController::class, 'index']);
Route::get('/evenements/{id}', [EvenementController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profil', [UtilisateurController::class, 'profil']);

    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/{id}', [ReservationController::class, 'show']);
    Route::post('/reservations', [ReservationController::class, 'store']);




    Route::middleware('admin')->group(function () {
        Route::post('/register-admin', [AuthController::class, 'registerAdmin']);
        Route::apiResource('/utilisateurs', UtilisateurController::class);
        Route::apiResource('/categories', CategorieController::class)->except(['index', 'show']);
        Route::apiResource('/evenements', EvenementController::class)->except(['index', 'show']);
        Route::apiResource('/reservations', ReservationController::class)->except(['index', 'show', 'store']);
    });
});
