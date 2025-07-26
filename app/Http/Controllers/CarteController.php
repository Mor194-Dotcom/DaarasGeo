<?php

/* namespace App\Http\Controllers;

use App\Models\Daara;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CarteController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isResponsable()) {
            $daaras = Daara::where('responsable_id', $user->id)
                ->with('zoneDelimitee')->get();
        } else {
            $daaras = Daara::with('zoneDelimitee')->get();
        }

        return view('cartes.index', compact('daaras'));
    }
} */

/* namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Daara;
use App\Models\Talibe;

class CarteController extends Controller
{
    /*  public function index()
    {
        $user = auth()->user();

        if ($user->isResponsable()) {
            // 🧑‍💼 Filtrer par responsable
            $responsable = $user->responsableDaara;

            if (!$responsable) {
                abort(403, "Accès refusé : vous n’êtes pas un responsable valide.");
            }

            $daaras = $responsable->daaras()->with('zoneDelimitee')->get();
        } else {
            // 👑 Admin → voit tout
            $daaras = \App\Models\Daara::with('zoneDelimitee')->get();
        }

        return view('cartes.index', compact('daaras', 'user'));
    }
    public function index()
    {
        $user = auth()->user();

        if ($user->isResponsable()) {
            $responsable = $user->responsableDaara;
            if (!$responsable) {
                abort(403, "Accès refusé : vous n’êtes pas un responsable valide.");
            }

            $daaras = $responsable->daaras()->with('zoneDelimitee')->get();

            $talibes = Talibe::with(['utilisateur', 'zone', 'daara.zoneDelimitee'])
                ->whereIn('daara_id', $daaras->pluck('id'))
                ->get();
        } elseif ($user->isTuteur()) {
            // 👨🏽‍🏫 Tuteur ➝ Talibés rattachés
            $talibes = Talibe::with(['utilisateur', 'zone', 'daara.zoneDelimitee'])
                ->where('tuteur_id', $user->id)
                ->get();

            $daaras = Daara::with('zoneDelimitee')
                ->whereIn('id', $talibes->pluck('daara_id')->unique())
                ->get();
        } else {
            // 👑 Admin
            $daaras = Daara::with('zoneDelimitee')->get();
            $talibes = Talibe::with(['utilisateur', 'zone', 'daara.zoneDelimitee'])->get();
        }

        return view('cartes.index', compact('daaras', 'talibes', 'user'));
    }
}
 */




namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Daara;
use App\Models\Talibe;
use App\Models\Tuteur;

class CarteController extends Controller
{
    public function index($daaraId = null)
    {
        $user = auth()->user();

        // 🎓 RESPONSABLE
        if ($user->isResponsable()) {
            $responsable = $user->responsableDaara;

            if (!$responsable) {
                abort(403, "Accès refusé : vous n’êtes pas un responsable valide.");
            }

            $daaras = $responsable->daaras()->with('zoneDelimitee')->get();

            $talibes = Talibe::with(['utilisateur', 'zone', 'daara.zoneDelimitee'])
                ->whereIn('daara_id', $daaras->pluck('id'))
                ->get();
        }

        // 👨🏽‍🏫 TUTEUR
        elseif ($user->isTuteur()) {
            $tuteur = Tuteur::where('utilisateur_id', $user->id)->first();

            if (!$tuteur) {
                abort(403, "Accès refusé : aucun profil tuteur associé à ce compte.");
            }

            $talibes = Talibe::with(['utilisateur', 'zone', 'daara.zoneDelimitee'])
                ->where('tuteur_id', $tuteur->id)
                ->get();

            $daaras = Daara::with('zoneDelimitee')
                ->whereIn('id', $talibes->pluck('daara_id')->unique())
                ->get();
        }

        // 👑 ADMIN
        else {
            $daaras = Daara::with('zoneDelimitee')->get();

            $talibes = Talibe::with(['utilisateur', 'zone', 'daara.zoneDelimitee'])->get();
        }
        $focusDaara = $daaraId ? Daara::find($daaraId) : null;
        return view('cartes.index', compact('daaras', 'talibes', 'user', 'focusDaara'));
    }
}
