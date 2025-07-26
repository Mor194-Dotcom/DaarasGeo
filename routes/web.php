<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\InscriptionController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TuteurDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\DaaraController;
use App\Http\Controllers\ZoneAdminController;
use App\Http\Controllers\ZoneDelimiteeController;
use App\Http\Controllers\TalibeController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RechercheController;

use App\Models\Talibe;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;




//route de la page d'acceuil
Route::get('/', function () {
    return view('welcome');
})->name('welcome');



// route pour auth (log in & log out)

// Formulaire de connexion
Route::get('/showlogin', [LoginController::class, 'showLoginForm'])->name('login');

// Soumission du formulaire
Route::post('/login', [LoginController::class, 'processLogin'])->name('login.process');

// Déconnexion

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('welcome');
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
// les routes pour daaras

Route::resource('daaras', DaaraController::class);
Route::get('/cartes/{daara?}', [CarteController::class, 'index'])->name('cartes.index');

// routes pour zone ajout
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/zones/manquantes', [ZoneAdminController::class, 'index'])
        ->name('zones.admin.missing');
});

Route::get('/zones/create/{daara}', [ZoneDelimiteeController::class, 'create'])->name('zones.create');
Route::post('/zones/store-auto', [ZoneDelimiteeController::class, 'storeAuto'])->name('zones.storeAuto');
Route::post('/zones/store', [ZoneDelimiteeController::class, 'store'])->name('zones.store');
//routes lies a talibes notre brain sys


Route::get('/daaras/{daara}/talibes/create', [TalibeController::class, 'create'])->name('daaras.talibes.create');
Route::post('/daaras/{daara}/talibes', [TalibeController::class, 'store'])->name('daaras.talibes.store');
// CRUD principal talibe
Route::resource('talibes', TalibeController::class);
//simulation talibe deplacement

Route::get('/simulation/run', [SimulationController::class, 'run']);
Route::get('/talibes/{talibe}/export', [TalibeController::class, 'export'])->name('talibes.export');
Route::get('/talibes/{talibe}/parcours', [TalibeController::class, 'parcours'])->name('talibes.parcours');
//assigne tuteur
Route::get('/talibes/{talibe}/attribuer-tuteur', [TalibeController::class, 'assignTuteurForm'])->name('talibes.assignTuteurForm');
Route::post('/talibes/{talibe}/attribuer-tuteur', [TalibeController::class, 'assignTuteur'])->name('talibes.assignTuteur');


use App\Mail\AlerteDeclencheeMail;

Route::get('/test-mail', function () {
    $user = \App\Models\Utilisateur::first();
    $alerte = \App\Models\Alerte::latest()->first();

    Mail::to($user->email)->send(new AlerteDeclencheeMail($alerte, $user));

    return '✅ Email envoyé à ' . $user->email;
});
// test notif laravel
Route::get('/test-notif', function () {
    $user = \App\Models\Utilisateur::find(1); // un utilisateur avec email valide
    $alerte = \App\Models\Alerte::latest()->first();

    $user->notify(new \App\Notifications\AlerteTalibeNotification($alerte));

    return '✅ Notification envoyée à ' . $user->email;
});
// test mail
Route::get('/test-position/{id}', function ($id) {
    $talibe = Talibe::findOrFail($id);
    app(TalibeController::class)->appliquerPosition($talibe, 14.654060, -15.526217);
});
// route simulation d'un seul talibe
Route::post('/talibes/{talibe}/toggle-position', [TalibeController::class, 'togglePosition'])->name('talibes.toggle');
//routes de la phase mot de passe oublie
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.code.form');
Route::post('/send-code', [PasswordResetController::class, 'sendCode'])->name('password.code.send');
// verificatio  et validation de code
Route::get('/verify-code', [PasswordResetController::class, 'showVerifyForm'])->name('verify.code');
Route::post('/verify-code', [PasswordResetController::class, 'verifyCode'])->name('password.code.verify');
//route de reinitialisation
Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
// route de notification
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{notification}/valider', [NotificationController::class, 'valider'])->name('notifications.valider');
//route de gestion users


// Groupe admin (si tu utilises des préfixes ou middleware)
Route::prefix('admin/utilisateurs')->name('admin.utilisateurs.')->group(function () {
    // Listing filtré
    Route::get('/', [UtilisateurController::class, 'index'])->name('index');

    // Fiche utilisateur
    Route::get('{id}/edit', [UtilisateurController::class, 'edit'])->name('edit');

    // Formulaire de création
    Route::get('create', [UtilisateurController::class, 'create'])->name('create');

    // Enregistrement en base
    Route::post('/', [UtilisateurController::class, 'store'])->name('store');

    // Suppression sécurisée
    Route::delete('{id}', [UtilisateurController::class, 'destroy'])->name('destroy');

    // Envoi email libre (manuel)
    Route::post('{id}/email-libre', [UtilisateurController::class, 'envoyerEmailLibre'])->name('emailLibre');

    // Email préconfiguré (alerte ou message automatique)
    Route::get('{id}/email', [UtilisateurController::class, 'envoyerEmail'])->name('email');

    Route::get('/admin/utilisateurs/{id}/email-libre-preview', [UtilisateurController::class, 'previewEmailLibre'])->name('emailLibrePreview');

    // SMS (si tu le réintègres plus tard)
    // Route::get('{id}/sms', [UtilisateurController::class, 'envoyerSms'])->name('sms');
    // Envoi SMS libre (manuel)
    Route::post('{id}/sms-libre', [UtilisateurController::class, 'envoyerSmsLibre'])->name('smsLibre');

    // Prévisualisation SMS (optionnel)
    Route::get('{id}/sms-preview', [UtilisateurController::class, 'previewSmsLibre'])->name('smsLibrePreview');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
});
// rechercher daaras , talibes

Route::get('/recherche', [RechercheController::class, 'index'])->name('recherche');
