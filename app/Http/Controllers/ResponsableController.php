<?php

/* namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Daara;
use App\Models\Alerte;
use App\Models\Utilisateur;
use App\Models\ZoneDelimitee;

class ResponsableController extends Controller
{
    public function dashboard()
    {


        $user = Auth::user();
        $responsable = $user->responsableDaara;

        if (!$responsable) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à ce tableau de bord.');
        }

        $daaras = $responsable->daaras()->with('zoneDelimitee')->get();
        $zonesIds = $daaras->pluck('zone_delimitee_id')->filter()->unique();

        $totalDaaras = $daaras->count();
        $totalZones = ZoneDelimitee::count();
        $totalAlertes = Alerte::whereIn('zone_delimitee_id', $zonesIds)->count();

        $alertes = Alerte::whereIn('zone_delimitee_id', $zonesIds)
            ->latest()->take(5)->get();

        return view('Dashboards.ResDaaraDash', compact(
            'user',
            'totalDaaras',
            'totalZones',
            'totalAlertes',
            'daaras',
            'alertes'
        ));
    }
}
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Daara;
use App\Models\Alerte;
use App\Models\ResponsableDaara;

class ResponsableController extends Controller
{
    public function dashboard()
    {
        // 👤 Utilisateur actuel
        $user = Auth::user();

        // 🔐 Vérification du rôle responsable
        $responsable = $user->responsableDaara;
        if (!$responsable) {
            abort(403, "Accès refusé : vous n'êtes pas responsable d'un Daara.");
        }

        // 🏫 Daaras gérés
        $daaras = $responsable->daaras()
            ->with('zoneDelimitee')          // Préchargement des zones
            ->withCount('talibes')           // Compte direct des talibés
            ->get();

        // 🧮 Statistiques
        $totalDaaras = $daaras->count();
        $totalTalibes = $daaras->sum('talibes_count');

        // 📍 ID des zones concernées
        $zoneIds = $daaras->pluck('zoneDelimitee.id')->filter()->unique();

        // 🚨 Alertes liées aux zones du responsable
        $totalAlertes = Alerte::whereIn('zone_id', $zoneIds)->count();
        $alertes = Alerte::whereIn('zone_id', $zoneIds)
            ->latest()
            ->take(5)
            ->get();

        // 📦 Vue associée
        return view('Dashboards.ResDaaraDash', compact(
            'user',
            'daaras',
            'alertes',
            'totalDaaras',
            'totalTalibes',
            'totalAlertes'
        ));
    }
}
