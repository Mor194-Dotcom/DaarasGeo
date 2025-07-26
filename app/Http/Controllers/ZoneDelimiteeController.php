<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZoneDelimiteeController extends Controller
{
    //
    public function create(\App\Models\Daara $daara)
    {
        if ($daara->zoneDelimitee) {
            return redirect()->route('zones.admin.missing')->with('error', 'Zone déjà créée.');
        }

        return view('zones.create', compact('daara'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'rayon' => 'required|numeric|min:10',
            'daara_id' => 'required|exists:daaras,id',
        ]);

        $daara = \App\Models\Daara::find($validated['daara_id']);

        if ($daara->zoneDelimitee) {
            return back()->with('error', 'Ce Daara a déjà une zone.');
        }

        \App\Models\ZoneDelimitee::create($validated);

        return redirect()->route('zones.admin.missing')->with('success', 'Zone enregistrée.');
    }

    public function storeAuto(Request $request)
    {
        $daara = \App\Models\Daara::findOrFail($request->daara_id);

        if ($daara->zoneDelimitee) {
            return back()->with('error', 'Ce Daara a déjà une zone.');
        }

        \App\Models\ZoneDelimitee::create([
            'latitude' => $daara->latitude,
            'longitude' => $daara->longitude,
            'rayon' => 150, // valeur par défaut
            'daara_id' => $daara->id,
        ]);

        return back()->with('success', 'Zone créée automatiquement.');
    }
}
