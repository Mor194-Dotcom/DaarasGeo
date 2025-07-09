<?php

namespace App\Http\Controllers;

use App\Models\Daara;
use App\Models\Talibe;
use App\Models\ResponsableDaara;
use App\Models\Alerte;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalDaaras = Daara::count();
        $totalTalibes = Talibe::count();
        $totalResponsables = ResponsableDaara::count();
        $totalAlertes = Alerte::count();

        $alertesParJour = Alerte::selectRaw('DATE(created_at) as jour, COUNT(*) as total')
            ->groupBy('jour')
            ->orderBy('jour', 'desc')
            ->limit(7)
            ->get()
            ->reverse();

        $alertesJours = $alertesParJour->pluck('jour')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray();
        $alertesCount = $alertesParJour->pluck('total')->toArray();

        return view('Dashboards.AdminDashboard', compact(
            'totalDaaras',
            'totalTalibes',
            'totalResponsables',
            'totalAlertes',
            'alertesJours',
            'alertesCount'
        ));
    }
}
