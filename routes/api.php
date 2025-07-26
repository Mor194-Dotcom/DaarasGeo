<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TalibeController;
use App\Http\Controllers\SimulationController;
use App\Models\Talibe;

//Route::post('/talibes/position', [TalibeController::class, 'updatePosition']);
/* Route::get('/talibes/live', [TalibeController::class, 'livePositions']);
Route::post('/talibes/position', [TalibeController::class, 'updatePosition']);
Route::get('/simulation/run', function () {
    Talibe::whereNotNull('latitude')->whereNotNull('longitude')->each(function ($t) {
        $t->latitude += mt_rand(-80, 80) / 10000;
        $t->longitude += mt_rand(-80, 80) / 10000;
        $t->save();
    });

    return response()->json(['message' => '🚀 Talibés déplacés avec succès']);
});
 */

Route::get('/talibes/live', [TalibeController::class, 'livePositions']);
Route::post('/talibes/position', [TalibeController::class, 'updatePosition']);
Route::get('/simulation/run', [SimulationController::class, 'run']);
