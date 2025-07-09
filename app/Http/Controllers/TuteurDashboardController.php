<?php

namespace App\Http\Controllers;

use App\Models\Tuteur;
use App\Models\Alerte;
use Illuminate\Http\Request;

class TuteurDashboardController extends Controller
{
    public function index()
    {
        // 🔧 Simulation ou auth plus tard
        $tuteur = Tuteur::with('utilisateur', 'talibes.alertes')->find(1); // ou Auth::user()->tuteur

        if (!$tuteur) {
            abort(403, 'Aucun tuteur disponible.');
        }

        $totalTalibes = $tuteur->talibes->count();

        $alertes = Alerte::whereIn('talibe_id', $tuteur->talibes->pluck('id'))
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
