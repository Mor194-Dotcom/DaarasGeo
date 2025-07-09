<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Tuteur;
use App\Models\ResponsableDaara;
use App\Models\Administrateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Enums\TypeTuteurEnum;
use App\Models\RoleEnum;



class InscriptionController extends Controller
{
    //
    public function create()
    {
        // Ne PAS inclure l'Administrateur dans la liste
        $roles = RoleEnum::whereNotIn('libelle', ['Administrateur', 'Talibe'])->get();
        return view('Auth.register', compact('roles'));
    }

    public function store(Request $request)
    {
        // Récupération du rôle sélectionné
        $role = RoleEnum::findOrFail($request->role_enum_id);

        // Blocage des rôles interdits à l'inscription
        if (in_array($role->libelle, ['Administrateur', 'Talibe'])) {
            abort(403, 'Ce rôle ne peut pas être attribué par l’inscription.');
        }

        // dd($request->all());

        // Validation des champs selon le rôle choisi
        $validated = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'adresse' => 'required|string',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|confirmed|min:8',
            'role_enum_id' => 'required|exists:role_enums,id',

            // Champs spécifiques au Tuteur (rôle 1)
            'type_tuteur' => ['required_if:role_enum_id,1', Rule::in(TypeTuteurEnum::values())],
            'telephone_tuteur' => 'required_if:role_enum_id,1',

            // Champs spécifiques au Responsable (rôle 2)
            'telephone_responsable' => 'required_if:role_enum_id,2',
        ]);


        // Création de l'utilisateur
        $utilisateur = Utilisateur::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'adresse' => $validated['adresse'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_enum_id' => $validated['role_enum_id'],
        ]);

        // Enregistrement du profil spécifique selon le rôle
        match ((int)$validated['role_enum_id']) {
            1 => Tuteur::create([
                'utilisateur_id' => $utilisateur->id,
                'type_tuteur' => $validated['type_tuteur'],
                'email' => $utilisateur->email,
                'mot_de_passe' => $utilisateur->password,
                'telephone' => $validated['telephone_tuteur']
            ]),
            2 => ResponsableDaara::create([
                'utilisateur_id' => $utilisateur->id,
                'email' => $utilisateur->email,
                'mot_de_passe' => $utilisateur->password,
                'telephone' => $validated['telephone_responsable']
            ]),
        };

        // Connexion automatique de l'utilisateur
        Auth::login($utilisateur);

        // Redirection selon le rôle
        return $this->redirectByRole($utilisateur);
    }


    private function redirectByRole($user)
    {
        return match ($user->role->libelle) {
            'ResponsableDaara' => redirect()->route('responsableDash'),
            'Tuteur' => redirect()->route('Tuteur.dashboard'),
            default => abort(403, 'Rôle interdit'),
        };
    }
}
