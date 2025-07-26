<?php

namespace App\Http\Controllers;

use App\Models\Daara;
use App\Models\ZoneDelimitee;
use App\Models\Utilisateur;
use App\Models\ResponsableDaara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaaraController extends Controller
{
    // 🗒️ Liste des daaras
    public function index()
    {

        /** @var \App\Models\Utilisateur $user */
        // recuperation du user connecter
        $user = Auth::user();

        //   dd($user);
        // Si admin : il voit tous les daaras
        if ($user->isAdmin()) {
            $daaras = Daara::with('responsable')->get();
            // $res = ResponsableDaara::with('utilisateur')->get();
        }
        // Si responsable : il voit uniquement ses daaras
        elseif ($user->isResponsable()) {
            $daaras = Daara::with('responsable')
                ->where('responsable_id', $user->responsableDaara->id)
                ->get();
        }
        // Sinon, accès refusé
        else {
            abort(403, 'Accès non autorisé.');
        }

        return view('daaras.index', compact('daaras'));
    }


    // 🆕 Formulaire de création
    public function create()
    {
        $responsables = ResponsableDaara::with('utilisateur')->get();
        return view('daaras.create', compact('responsables'));
    }

    // 💾 Enregistrement dans la BDD
    /*   public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'responsable_id' => 'required|exists:responsable_daaras,id',
        ]);

        Daara::create($validated);
        return redirect()->route('daaras.index')->with('success', 'Daara créée avec succès !');
    } */
    public function store(Request $request)
    {
        // Validation commune
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'rayon' => 'required|numeric|min:100',
            // Le champ responsable_id est facultatif ici (ajouté conditionnellement plus bas)
        ]);

        // $user = Auth::user();
        $user = auth()->user();
        // dd($user->isAdmin(), $user->administrateur);

        // 💡 Si admin ➝ récupère responsable choisi dans le formulaire
        if ($user->isAdmin()) {
            $validated['responsable_id'] = $request->input('responsable_id');
        }

        // 👨🏽‍🏫 Si responsable ➝ associer automatiquement son propre ID via la relation
        if ($user->isResponsable()) {
            $validated['responsable_id'] = optional($user->responsableDaara)->id;

            // Protection au cas où responsableDaara n’est pas défini
            if (!$validated['responsable_id']) {
                return redirect()->back()->withErrors(['responsable_id' => 'Votre profil responsable est incomplet.']);
            }
        }

        // 🔐 Optionnel : empêcher la création si aucun responsable ID valide
        if (empty($validated['responsable_id'])) {
            return redirect()->back()->withErrors(['responsable_id' => 'Responsable non défini.']);
        }

        // 🔃 Création du Daara et zone de securite en meme temps
        $daara = Daara::create($validated);

        ZoneDelimitee::create([
            'latitude' => $daara->latitude,
            'longitude' => $daara->longitude,
            'rayon' => $validated['rayon'],
            'daara_id' => $daara->id,
        ]);

        return redirect()->route('daaras.index')->with('success', 'Daara créé avec succès !');
    }

    // 👁️ Affichage d’un daara
    public function show(Daara $daara)
    {
        $daara->load('responsable', 'talibes', 'zone');
        return view('daaras.show', compact('daara'));
    }

    // ✏️ Formulaire de modification
    public function edit(Daara $daara)
    {
        $responsables = Utilisateur::where('role_enum_id', 'responsable')->get();
        return view('daaras.edit', compact('daara', 'responsables'));
    }


    // 🔄 Mise à jour
    /*  public function update(Request $request, Daara $daara)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'rayon' => 'required|numeric|min:10',
        ]);

        $daara->update([
            'nom' => $validated['nom'],
            'adresse' => $validated['adresse'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'responsable_id' => $request->responsable_id,
        ]);

        // Mettre à jour la zones
        if ($daara->zoneDelimitee) {
            $daara->zoneDelimitee->update(['rayon' => $validated['rayon']]);
        } else {
            ZoneDelimitee::create([
                'latitude' => $daara->latitude,
                'longitude' => $daara->longitude,
                'rayon' => $validated['rayon'],
                'daara_id' => $daara->id,
            ]);
        }
    } */
    public function update(Request $request, Daara $daara)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'rayon' => 'required|numeric|min:10',
        ]);

        $updateData = [
            'nom' => $validated['nom'],
            'adresse' => $validated['adresse'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ];

        // ✅ Ajouter responsable uniquement si admin
        if (auth()->user()->isAdmin() && $request->filled('responsable_id')) {
            $updateData['responsable_id'] = $request->responsable_id;
        }

        $daara->update($updateData);

        // ✅ Mise à jour de la zone
        if ($daara->zoneDelimitee) {
            $daara->zoneDelimitee->update(['rayon' => $validated['rayon']]);
        } else {
            ZoneDelimitee::create([
                'latitude' => $daara->latitude,
                'longitude' => $daara->longitude,
                'rayon' => $validated['rayon'],
                'daara_id' => $daara->id,
            ]);
        }

        return redirect()->route('daaras.edit', $daara)->with('success', 'Daara mis à jour avec succès.');
    }

    // 🗑️ Suppression
    public function destroy(Daara $daara)
    {
        $daara->delete();
        return redirect()->route('daaras.index')->with('success', 'Daara supprimée.');
    }
}
