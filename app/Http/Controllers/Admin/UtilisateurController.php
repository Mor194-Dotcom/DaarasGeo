<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\RoleEnum;
use App\Models\Tuteur;
use App\Models\ResponsableDaara;
use App\Models\Administrateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageLibreAdmin;
use Illuminate\Validation\Rule;
use App\Services\SmsDispatcher;


class UtilisateurController extends Controller
{
    /**
     * Affiche la liste des utilisateurs avec filtres.
     */
    public function index(Request $request)
    {
        $search = trim(strtolower($request->search));

        $utilisateurs = Utilisateur::query()
            ->with(['role', 'tuteur', 'responsableDaara', 'administrateur'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nom) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(prenom) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"]);
                })
                    ->orWhereHas('tuteur', fn($r) => $r->where('telephone', 'like', "%{$search}%"))
                    ->orWhereHas('responsableDaara', fn($r) => $r->where('telephone', 'like', "%{$search}%"))
                    ->orWhereHas('administrateur', fn($r) => $r->where('telephone', 'like', "%{$search}%"));
            })
            ->when($request->filled('role'), fn($q) => $q->where('role_enum_id', $request->role))
            ->paginate(20);

        return view('admin.utilisateurs.index', [
            'utilisateurs' => $utilisateurs,
            'roles' => RoleEnum::all()
        ]);
    }

    /**
     * Affiche la fiche complète d’un utilisateur.
     */
    public function edit($id)
    {
        $utilisateur = Utilisateur::with([
            'role',
            'tuteur.talibes',
            'responsableDaara.daaras',
            'administrateur'
        ])->findOrFail($id);

        return view('admin.utilisateurs.edit', compact('utilisateur'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        return view('admin.utilisateurs.create', [
            'roles' => RoleEnum::all()
        ]);
    }

    /**
     * Traite la création d’un utilisateur et son profil.
     */
    public function store(Request $request)
    {
        // Validation dynamique selon le rôle
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'adresse' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|confirmed|min:8',
            'role_enum_id' => 'required|exists:role_enums,id',

            // Champs métier
            'type_tuteur' => ['required_if:role_enum_id,1', Rule::in(\App\Models\Enums\TypeTuteurEnum::values())],
            'telephone_tuteur' => 'required_if:role_enum_id,1',
            'telephone_responsable' => 'required_if:role_enum_id,2',
            'telephone_admin' => 'required_if:role_enum_id,4',
        ]);

        // Création utilisateur principal
        $utilisateur = Utilisateur::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'adresse' => $validated['adresse'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_enum_id' => $validated['role_enum_id'],
        ]);

        // Création du modèle métier associé
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
            4 => Administrateur::create([
                'utilisateur_id' => $utilisateur->id,
                'email' => $utilisateur->email,
                'mot_de_passe' => $utilisateur->password,
                'telephone' => $validated['telephone_admin']
            ]),
        };

        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Suppression d’un utilisateur.
     */
    public function destroy($id)
    {
        Utilisateur::destroy($id);

        return back()->with('success', 'Utilisateur supprimé.');
    }

    /**
     * Envoi d’un message manuel par email.
     */

    public function envoyerEmailLibre(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'required|string|max:2000'
        ]);

        $utilisateur = Utilisateur::findOrFail($id);

        Mail::to($utilisateur->email)->send(new MessageLibreAdmin($utilisateur, $request->contenu));

        return back()->with('success', 'Message envoyé à ' . $utilisateur->nom);
    }

    public function previewEmailLibre(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $contenu = $request->query('contenu') ?? 'Aucun message fourni';

        return view('emails.message_libre_admin', [
            'nom' => $utilisateur->nom,
            'contenu' => $contenu,
            'utilisateur' => $utilisateur, // 👈 cette ligne est indispensable
        ]);
    }
    public function previewSmsLibre(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $contenu = $request->query('contenu', '');

        return view('admin.utilisateurs.sms-preview', compact('utilisateur', 'contenu'));
    }

    public function envoyerSmsLibre(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'required|string|max:160'
        ]);

        $utilisateur = Utilisateur::with(['tuteur', 'responsableDaara', 'administrateur'])->findOrFail($id);

        // 🔍 Détection du bon téléphone selon le rôle
        $telephone = $utilisateur->tuteur->telephone
            ?? $utilisateur->responsableDaara->telephone
            ?? $utilisateur->administrateur->telephone;

        if (!$telephone) {
            return back()->with('error', 'Téléphone introuvable pour cet utilisateur.');
        }

        // 🚀 Envoi avec dispatcher : Infobip → fallback Twilio
        $dispatcher = new SmsDispatcher();
        $success = $dispatcher->send($telephone, $request->contenu);

        return back()->with(
            $success ? 'success' : 'error',
            $success
                ? 'SMS envoyé à ' . $utilisateur->nom
                : 'Échec d’envoi du SMS.'
        );
    }
}
