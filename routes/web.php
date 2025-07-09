<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\InscriptionController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TuteurDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CarteController;
use Illuminate\Support\Facades\Auth;



// route pour auth (log in & log out)

// Formulaire de connexion
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

// Soumission du formulaire
Route::post('/login', [LoginController::class, 'processLogin'])->name('login.process');

// Déconnexion
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// route auth(sign-up )
Route::get('/register', [InscriptionController::class, 'create'])->name('sign-up');
Route::post('/storeAuth', [InscriptionController::class, 'store'])->name('store.validate');

// Groupement sécurisé
Route::middleware(['auth'])->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/responsable', [ResponsableController::class, 'dashboard'])->name('responsableDash');
    Route::get('/tuteur-dashboard', [TuteurDashboardController::class, 'index'])->name('tuteur.dashboard');
});


// route vers la carte
// web.php
Route::get('/cartes', [CarteController::class, 'index'])->name('Show.carte');
