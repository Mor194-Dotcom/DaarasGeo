<?php

/* namespace App\Http\Controllers;

use App\Models\Tuteur;
use App\Models\Alerte;
use Illuminate\Http\Request;
/*
{
    public function index()
    {
        // 🔧 Simulation ou auth plus tard
        $tuteur = Tuteur::with('utilisateur', 'talibes.utilisateur')->find(1);

        if (!$tuteur) {
            abort(403, 'Aucun tuteur disponible.');
        }

        $totalTalibes = $tuteur->talibes->count();

        $utilisateurIds = $tuteur->talibes->pluck('utilisateur_id');

        $alertes = Alerte::whereIn('utilisateur_id', $utilisateurIds)
            ->latest()
            ->take(5)
            ->get();



        return view('Dashboards.TuteurDashboard', compact(
            'tuteur',
            'totalTalibes',
            'alertes'
        ));
    }
}


class TuteurDashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        // 🔗 Récupère le profil Tuteur lié
        $tuteur = Tuteur::where('utilisateur_id', $user->id)
            ->with(['utilisateur', 'talibes.utilisateur', 'talibes.zone', 'talibes.daara'])
            ->first();

        if (!$tuteur) {
            abort(403, 'Accès refusé : vous n’êtes pas un tuteur valide.');
        }

        // 📊 Talibés supervisés
        $talibes = $tuteur->talibes;

        // 🔍 IDs des utilisateurs des Talibés
        $talibeUtilisateurIds = $talibes->pluck('utilisateur_id');

        // 🔔 Alertes liées à ces utilisateurs
        $alertes = Alerte::with('utilisateur')
            ->whereIn('utilisateur_id', $talibeUtilisateurIds)
            ->latest()
            ->take(5)
            ->get();

        return view('Dashboards.TuteurDashboard', compact(
            'tuteur',
            'talibes',
            't'
            'alertes'
        ));
    }
}
 */


namespace App\Http\Controllers;

use App\Models\Tuteur;
use App\Models\Alerte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TuteurDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 🔗 Récupère le profil Tuteur lié
        $tuteur = Tuteur::where('utilisateur_id', $user->id)
            ->with(['utilisateur', 'talibes.utilisateur', 'talibes.zone', 'talibes.daara'])
            ->first();

        if (!$tuteur) {
            abort(403, 'Accès refusé : vous n’êtes pas un tuteur valide.');
        }

        // 📊 Talibés supervisés
        $talibes = $tuteur->talibes;

        // 🧮 Total des talibés
        $totalTalibes = $talibes->count();

        // 🔍 IDs des utilisateurs liés aux Talibés
        $talibeUtilisateurIds = $talibes->pluck('utilisateur_id');

        // 🔔 Alertes associées à ces utilisateurs
        $alertes = Alerte::with('utilisateur')
            ->whereIn('utilisateur_id', $talibeUtilisateurIds)
            ->latest()
            ->take(5)
            ->get();

        return view('Dashboards.TuteurDashboard', compact(
            'tuteur',
            'talibes',
            'totalTalibes',
            'alertes'
        ));
    }
}
