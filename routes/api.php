<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AnnonceController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers;


// UserController (login/register/logout)
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes (require Sanctum auth)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::apiResource('annonces', AnnonceController::class);


    // Routes API pour les catégories

    // CRUD classique
    Route::apiResource('categories', CategorieController::class);

    // Route pour récupérer toutes les catégories avec leurs annonces
    Route::get('categories-avec-annonces', [CategorieController::class, 'annoncesParCategorie']);

    // Route pour récupérer toutes les catégories avec leurs annonces triées par date
    Route::get('categories-avec-annonces-triees', [CategorieController::class, 'triAnnoncesParDate']);




     Route::put('/user', [UserController::class, 'update']);
});
