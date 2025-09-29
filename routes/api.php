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

    Route::post('/annonces', [AnnonceController::class, 'store']);
    Route::get('/annonces', [AnnonceController::class, 'index']);
    Route::put('/annonces/{annonce}', [AnnonceController::class, 'update']);
    Route::get('/annonces/tri-date',[AnnonceController::class, 'triAnnoncesParDate']);
    Route::get('/annonces/{titre}',[AnnonceController::class, 'chercherAnnonceParTitre']);
    Route::delete('/annonces/{annonce}', [AnnonceController::class, 'destroy']);


    // Routes API pour les catégories
    // Route pour récupérer toutes les catégories avec leurs annonces
    Route::get('categories-avec-annonces', [CategorieController::class, 'annoncesParCategorie']);

    // Routes API pour les messages
    Route::post('/annonces/{annonce}/messages', [MessageController::class, 'store']);
    Route::get('/annonces/{annonce}/messages', [MessageController::class, 'index']);
    Route::get('messages/{message}', [MessageController::class, 'update']);
    Route::delete('/messages/{message}', [MessageController::class, 'destroy']);











    // CRUD classique
    //Route::apiResource('categories', CategorieController::class);


    // Route pour récupérer toutes les catégories avec leurs annonces triées par date
    //Route::get('categories-avec-annonces-triees', [CategorieController::class, 'triAnnoncesParDate']);




     Route::put('/user', [UserController::class, 'update']);
});
