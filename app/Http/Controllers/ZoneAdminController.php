<?php

namespace App\Http\Controllers;

use App\Models\Daara;
use Illuminate\Http\Request;

class ZoneAdminController extends Controller
{
    public function index()
    {
        $daarasSansZone = Daara::doesntHave('zoneDelimitee')->get();
        return view('admin.zones.index', compact('daarasSansZone'));
    }
}
