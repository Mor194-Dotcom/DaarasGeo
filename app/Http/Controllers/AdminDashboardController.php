<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Daara;
use App\Models\Talibe;
use App\Models\ResponsableDaara;
use App\Models\Alerte;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        //  $user = Auth::user();
        $user = auth()->user();
        // 🔒 Récupération des daaras selon rôle
        $daaras = match (true) {
            $user->isAdmin() => Daara::with('responsable', 'zoneDelimitee')->withCount('talibes')->get(),
            $user->isResponsable() => Daara::with('responsable', 'zoneDelimitee')
                ->where('responsable_id', optional($user->responsableDaara)->id)
                ->withCount('talibes')->get(),
            default => abort(403, 'Accès non autorisé.')
        };

        // 📊 Statistiques globales
        $totalDaaras = Daara::count();
        $totalTalibes = Talibe::count();
        $totalResponsables = ResponsableDaara::count();
        $totalAlertes = Alerte::count();

        // 📈 Statistiques alertes 7 derniers jours
        $alertesJours = collect(range(6, 0))->map(fn($d) => now()->subDays($d)->format('d/m'))->values();
        $alertesCount = $alertesJours->map(
            fn($label) =>
            Alerte::whereDate('created_at', Carbon::createFromFormat('d/m', $label))->count()
        )->values();

        $topDaaras = Daara::with('zoneDelimitee')
            ->get()
            ->map(function ($daara) {
                $zoneId = optional($daara->zoneDelimitee)->id;

                return [
                    'nom' => $daara->nom,
                    'count' => $zoneId ? Alerte::where('zone_id', $zoneId)->count() : 0
                ];
            })
            ->sortByDesc('count')
            ->take(3)
            ->values();

        $labels = $topDaaras->pluck('nom');
        $data = $topDaaras->pluck('count');


        // 🔁 Vue du dashboard
        return view('Dashboards.AdminDashboard', compact(
            'daaras',
            'totalDaaras',
            'totalTalibes',
            'totalResponsables',
            'totalAlertes',
            'alertesJours',
            'alertesCount',
            'labels',
            'data'
        ));
    }
}
