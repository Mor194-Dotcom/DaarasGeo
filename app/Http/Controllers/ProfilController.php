<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /**
     * Affiche les informations du profil utilisateur connecté.
     */
    public function show()
    {
        $utilisateur = Auth::user();
        return view('profil.show', compact('utilisateur'));
    }
}
