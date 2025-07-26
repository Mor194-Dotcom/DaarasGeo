<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Daara;
use App\Models\Talibe;
use Illuminate\Support\Facades\Auth;

class RechercheController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $type = $request->input('type', 'all');
        $user = auth()->user(); // ✔️


        $resultats = [];

        if ($user->isAdmin()) {
            if ($type === 'daara' || $type === 'all') {
                $resultats['daaras'] = Daara::where('nom', 'like', "%$q%")->get();
            }

            if ($type === 'talibe' || $type === 'all') {
                $resultats['talibes'] = Talibe::whereHas(
                    'utilisateur',
                    fn($query) =>
                    $query->where('nom', 'like', "%$q%")
                )->get();
            }
        }

        if ($user->isResponsable()) {
            if ($type === 'daara' || $type === 'all') {
                $resultats['daaras'] = Daara::where('responsable_id', $user->id)
                    ->where('nom', 'like', "%$q%")
                    ->get();
            }

            if ($type === 'talibe' || $type === 'all') {
                $resultats['talibes'] = Talibe::whereHas(
                    'daara',
                    fn($query) =>
                    $query->where('responsable_id', $user->id)
                        ->where('nom', 'like', "%$q%")
                )->get();
            }
        }

        if ($user->isTuteur()) {
            if ($type === 'talibe' || $type === 'all') {
                $resultats['talibes'] = Talibe::where('tuteur_id', $user->id)
                    ->whereHas(
                        'utilisateur',
                        fn($query) =>
                        $query->where('nom', 'like', "%$q%")
                    )->get();
            }
            // Les tuteurs n’ont pas accès aux Daaras
        }

        return view('recherche.resultats', compact('resultats', 'q', 'type'));
    }
}
