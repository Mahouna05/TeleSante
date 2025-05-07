<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Routes principales
Route::get('/', [PageController::class, 'accueil'])->name('accueil');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/a-propos', [PageController::class, 'aPropos'])->name('a-propos');
Route::get('/connexion', [PageController::class, 'connexion'])->name('connexion');
Route::get('/inscription', [PageController::class, 'inscription'])->name('inscription');