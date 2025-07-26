<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traite la tentative de connexion
     */
    public function processLogin(Request $request)
    {
        // Récupère les identifiants du formulaire
        $credentials = $request->only('email', 'password');

        // Vérifie si les identifiants sont valides
        if (Auth::attempt($credentials)) {
            // Récupère l'utilisateur connecté
            $utilisateur = Auth::user();

            $roleLibelle = $utilisateur->role?->libelle;

            if (!$roleLibelle) {
                Auth::logout();
                return back()->withErrors(['email' => 'Ce compte n’a pas de rôle associé.']);
            }

            return match ($roleLibelle) {
                'Administrateur' => redirect()->route('admin.dashboard'),
                'ResponsableDaara' => redirect()->route('responsableDash'),
                'Tuteur' => redirect()->route('tuteur.dashboard'),
                default => abort(403, 'Rôle non reconnu')
            };
        }

        // Échec : retourne au formulaire avec erreur
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.'
        ]);
    }
}
