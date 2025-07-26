<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Models\Enums\TypeTuteurEnum;
use Illuminate\Validation\Rule;
use App\Models\Talibe;
use App\Models\Utilisateur;
use App\Models\Daara;
use App\Models\Tuteur;
use App\Models\ZoneDelimitee;
use App\Models\Alerte;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlerteDeclencheeMail;
use App\Notifications\AlerteTalibeNotification;
use App\Services\SmsProviders\InfobipSmsProvider;
use App\Services\SmsProviders\TwilioSmsProvider;
use App\Services\SmsAlerteService;

class TalibeController extends Controller
{
    public function create(Daara $daara)
    {
        $zones = ZoneDelimitee::all();
        $tuteurs = Tuteur::with('utilisateur')->get();
        return view('talibes.create', compact('daara', 'zones', 'tuteurs'));
    }

    public function store(Request $request, Daara $daara)
    {
        // Récupérer la zone du Daara si aucune zone n’a été explicitement fournie
        //   $zoneId = $daara->zoneDelimitee ? $daara->zoneDelimitee->id : null;
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'adresse' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'photo' => 'nullable|image',
            'zone_id' => ['nullable', 'exists:zones_delimitees,id'],
            'tuteur_id' => 'nullable|exists:tuteurs,id'
        ]);
        $zone = $daara->zoneDelimitee;
        $position = $zone
            ? $this->simulatePositionInZone($zone->latitude, $zone->longitude, $zone->rayon)
            : $this->simulatePositionAround($daara->latitude, $daara->longitude); // fallback

        $zoneId = $request->zone_id ?? $daara->zoneDelimitee?->id;

        $email = 'talibe_' . Str::uuid() . '@system.local';
        $password = Hash::make(Str::random(12));

        $utilisateur = Utilisateur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'email' => $email,
            'password' => $password,
            'role_enum_id' => 3,
        ]);

        $photoPath = $request->file('photo')?->store('talibes', 'public');

        Talibe::create([
            'utilisateur_id' => $utilisateur->id,
            'date_naissance' => $request->date_naissance,
            'photo' => $photoPath,
            'latitude' => $position['latitude'],
            'longitude' => $position['longitude'],
            'daara_id' => $daara->id,
            'zone_id' => $zoneId,
            'tuteur_id' => $request->tuteur_id
        ]);

        return redirect()->route('daaras.show', $daara->id)->with('success', 'Talibé ajouté au Daara.');
    }
    private function simulatePositionInZone(float $centerLat, float $centerLng, float $rayon): array
    {
        // Rayon en mètres → converti en degrés (approximatif)
        $rayonDeg = $rayon / 111320;

        // Angle aléatoire
        $angle = mt_rand(0, 360);
        $angleRad = deg2rad($angle);

        // Distance aléatoire dans le cercle
        $distance = mt_rand(0, 1000) / 1000 * $rayonDeg;

        return [
            'latitude' => $centerLat + $distance * cos($angleRad),
            'longitude' => $centerLng + $distance * sin($angleRad)
        ];
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->isTuteur()) {
            $talibes = Talibe::where('tuteur_id', $user->id)
                ->with(['utilisateur', 'daara.zoneDelimitee', 'tuteur.utilisateur'])
                ->paginate(5);
        } elseif ($user->isResponsable()) {
            $responsable = $user->responsableDaara;
            if (!$responsable) {
                abort(403, "Accès refusé : Responsable invalide.");
            }

            $daaraIds = $responsable->daaras()->pluck('id');
            $talibes = Talibe::whereIn('daara_id', $daaraIds)
                ->with(['utilisateur', 'daara.zoneDelimitee', 'tuteur.utilisateur'])
                ->paginate(5);
        } else {
            // Admin
            $talibes = Talibe::with(['utilisateur', 'daara.zoneDelimitee', 'tuteur.utilisateur'])->paginate(7);
        }

        return view('talibes.index', compact('talibes'));
    }
    public function show(Talibe $talibe)
    {
        $talibe->load([
            'utilisateur',
            'daara.zoneDelimitee',
            'tuteur.utilisateur',
            'zone',
            'historiques' // Pour trajectoire GPS
        ]);

        return view('talibes.show', compact('talibe'));
    }
    public function edit(Talibe $talibe)
    {
        $zones = ZoneDelimitee::all();
        $tuteurs = Tuteur::with('utilisateur')->get();

        return view('talibes.edit', compact('talibe', 'zones', 'tuteurs'));
    }
    public function update(Request $request, Talibe $talibe)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'adresse' => 'nullable|string',
            'date_naissance' => 'nullable|date',
            'photo' => 'nullable|image',
            'zone_id' => 'nullable|exists:zones_delimitees,id',
            'tuteur_id' => 'nullable|exists:tuteurs,id',
        ]);

        $talibe->utilisateur->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('talibes', 'public');
            $talibe->photo = $photoPath;
        }

        $talibe->update([
            'date_naissance' => $request->date_naissance,
            'zone_id' => $request->zone_id,
            'tuteur_id' => $request->tuteur_id
        ]);

        return redirect()->route('talibes.show', $talibe)->with('success', 'Talibé mis à jour.');
    }
    public function destroy(Talibe $talibe)
    {
        $talibe->utilisateur->delete(); // Supprime le compte utilisateur lié
        $talibe->delete(); // Supprime le profil Talibé

        return redirect()->route('talibes.index')->with('success', 'Talibé supprimé.');
    }
    public function parcours(Talibe $talibe)
    {
        $talibe->load([
            'utilisateur',
            'daara.zoneDelimitee',
            'tuteur.utilisateur',
            'zone',
            'historiques' // Pour le tracé GPS
        ]);

        return view('talibes.parcours', compact('talibe'));
    }
    public function assignTuteurForm(Talibe $talibe)
    {
        return view('talibes.assign-tuteur', compact('talibe'));
    }

    public function assignTuteur(Request $request, Talibe $talibe)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'adresse' => 'nullable|string',
            'email' => 'required|email|unique:utilisateurs,email',
            'telephone' => 'required|string',
            'type_tuteur' => ['required', Rule::in(TypeTuteurEnum::values())],
            'mot_de_passe' => 'required|string|min:6'
        ]);

        $utilisateur = Utilisateur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'password' => Hash::make($request->mot_de_passe),
            'role_enum_id' => 1
        ]);

        $tuteur = Tuteur::create([
            'utilisateur_id' => $utilisateur->id,
            'email' => $request->email,
            'mot_de_passe' => $request->mot_de_passe, // facultatif si tu veux la stocker en clair
            'telephone' => $request->telephone,
            'type_tuteur' => $request->type_tuteur
        ]);

        $talibe->update(['tuteur_id' => $tuteur->id]);

        return redirect()->route('talibes.show', $talibe)->with('success', 'Tuteur attribué avec succès.');
    }


    public function export(Talibe $talibe)
    {
        $csv = "latitude,longitude,date\n";

        foreach ($talibe->historiques as $h) {
            $csv .= "{$h->latitude},{$h->longitude}," . $h->date->format('Y-m-d H:i') . "\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=talibe_{$talibe->id}_positions.csv"
        ]);
    }
    private function simulatePositionAround($lat, $lng): array
    {
        return [
            'latitude' => $lat + mt_rand(-50, 50) / 10000,
            'longitude' => $lng + mt_rand(-50, 50) / 10000
        ];
    }

    public function appliquerPosition(Talibe $talibe, float $latitude, float $longitude): void
    {
        // 🔁 Mise à jour de la position
        $talibe->latitude = $latitude;
        $talibe->longitude = $longitude;
        $talibe->save();

        // 🧾 Historique du déplacement
        $talibe->historiques()->create([
            'latitude' => $latitude,
            'longitude' => $longitude,
            'date' => now(),
            'type' => 'simulation'
        ]);

        // 🛡️ Récupération de la zone de sécurité
        $zone = $talibe->zone ?? $talibe->daara->zoneDelimitee;

        if (!$zone || !$zone->latitude || !$zone->longitude) {
            return; // Aucune vérification possible
        }

        // 📐 Calcul de la distance avec le centre de la zone
        $distance = $this->haversine($latitude, $longitude, $zone->latitude, $zone->longitude);



        // 🚨 Si le Talibé est hors zone, créer une alerte
        if ($distance > ($zone->rayon)) {
            $alerte = Alerte::create([
                'statut' => 'active',
                'zone_id' => $zone->id,
                'utilisateur_id' => $talibe->utilisateur->id ?? null,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'distance' => $distance,
                'date' => now()
            ]);

            $receveurs = collect();

            // ✅ Tuteur du Talibé
            $tuteur = Utilisateur::find($talibe->tuteur_id);
            if ($tuteur && filter_var($tuteur->email, FILTER_VALIDATE_EMAIL)) {
                $receveurs->push($tuteur);
            }
            $daara = $talibe->daara;
            $daara->load('responsable.utilisateur');

            $responsableUser = optional($daara->responsable)->utilisateur;

            if (
                $responsableUser &&
                $responsableUser->role_enum_id === 2 &&
                filter_var($responsableUser->email, FILTER_VALIDATE_EMAIL)
            ) {
                $receveurs->push($responsableUser);
            }


            // ✅ Tous les administrateurs
            $admins = Utilisateur::where('role_enum_id', 4)
                ->whereNotNull('email')
                ->get();

            $receveurs = $receveurs->merge($admins);


            // 🔔 Enregistrement + envoi
            foreach ($receveurs as $user) {
                Notification::create([
                    'contenu' => "🚨 Talibé hors zone : " . ($talibe->utilisateur->prenom ?? 'Talibé') . ' ' . ($talibe->utilisateur->nom ?? ''),
                    'vue' => false,
                    'est_critique' => true,
                    'date_envoi' => now(),
                    'utilisateur_id' => $user->id,
                    'alerte_id' => $alerte->id
                ]);

                $user->notify(new AlerteTalibeNotification($alerte));
                // 📱 SMS si numéro valide
                $numero = $user->getNumeroValide();

                if ($numero) {
                    // 🧼 Sécurisation du talibé pour affichage
                    $nomTalibe = $talibe->utilisateur ? $talibe->utilisateur->nom : 'Inconnu';
                    $date = now()->format('d/m/Y H:i');

                    // 📨 Message optimisé
                    $message = "🚨 DAARASGEO : Talibé hors zone détecté.\n"
                        . "Nom: {$nomTalibe}\n"
                        . "Date: {$date}";

                    // 📡 Tentative Infobip
                    $infobip = new InfobipSmsProvider();
                    if ($infobip->send($numero, $message)) {
                        Log::info("[appliquerPosition] SMS Infobip OK → $numero");
                        return;
                    }

                    // 🔄 Fallback Twilio
                    $twilio = new TwilioSmsProvider();
                    if ($twilio->send($numero, $message)) {
                        Log::info("[appliquerPosition] Infobip KO → Twilio OK → $numero");
                        return;
                    }

                    // ❌ Échec des deux
                    Log::error("[appliquerPosition] Échec total SMS → $numero");
                }
            }
        }
    }
    public function livePositions()
    {
        $talibes = Talibe::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with(['utilisateur', 'daara.zoneDelimitee', 'zone'])
            ->get();

        $resultats = $talibes->map(function ($t) {
            $zone = $t->zone ?? $t->daara->zoneDelimitee;

            if (!$zone || !$zone->latitude || !$zone->longitude || !$zone->rayon) {
                return null; // ❌ Zone invalide, ignorer
            }

            $distance = $this->haversine(
                $t->latitude,
                $t->longitude,
                $zone->latitude,
                $zone->longitude
            );

            return [
                'id' => $t->id,
                'latitude' => $t->latitude,
                'longitude' => $t->longitude,
                'est_hors_zone' => $distance > $zone->rayon, // ✅ Ajout ici
                'utilisateur' => [
                    'nom' => $t->utilisateur->nom ?? '',
                    'prenom' => $t->utilisateur->prenom ?? '',
                ],
                'daara' => [
                    'nom' => $t->daara->nom ?? '',
                ],
                'zone' => [
                    'nom' => $zone->nom ?? 'Zone inconnue',
                    'latitude' => $zone->latitude,
                    'longitude' => $zone->longitude,
                    'rayon' => $zone->rayon
                ]
            ];
        })->filter()->values(); // pour éviter les nulls

        return response()->json($resultats);
    }

    public function togglePosition(Talibe $talibe)
    {
        $zone = $talibe->zone ?? $talibe->daara->zoneDelimitee;

        if (!$zone || !$zone->latitude || !$zone->longitude) {
            return response()->json(['error' => 'Zone non définie'], 400);
        }

        $distance = $this->haversine($talibe->latitude, $talibe->longitude, $zone->latitude, $zone->longitude);

        $position = $distance <= $zone->rayon
            ? $this->simulateOutsideZone($zone->latitude, $zone->longitude, $zone->rayon)
            : ['latitude' => $zone->latitude, 'longitude' => $zone->longitude];

        $this->appliquerPosition($talibe, $position['latitude'], $position['longitude']);

        return response()->json(['success' => true]);
    }
    private function simulateOutsideZone(float $lat, float $lng, float $rayon): array
    {
        $rayonDeg = ($rayon + $rayon) / 111320;
        $angle = mt_rand(0, 360);
        $rad = deg2rad($angle);

        return [
            'latitude' => $lat + $rayonDeg * cos($rad),
            'longitude' => $lng + $rayonDeg * sin($rad)
        ];
    }


    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371000; // Rayon terrestre en mètres
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) ** 2 +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) ** 2;
        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
