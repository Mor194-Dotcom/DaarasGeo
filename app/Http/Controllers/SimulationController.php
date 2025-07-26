<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TalibeController;
use App\Models\Talibe;

class SimulationController extends Controller
{
    public function run()
    {
        $ctrl = new TalibeController();
        $deplaces = 0;
        $talibes = Talibe::whereNotNull('latitude')->whereNotNull('longitude')->get();

        foreach ($talibes as $t) {
            $newLat = $t->latitude + mt_rand(-80, 80) / 10000;
            $newLng = $t->longitude + mt_rand(-80, 80) / 10000;

            $ctrl->appliquerPosition($t, $newLat, $newLng);
            $deplaces++;
        }

        return response()->json([
            'message' => '✅ Simulation terminée',
            'talibes_deplaces' => $deplaces
        ]);
    }
}
