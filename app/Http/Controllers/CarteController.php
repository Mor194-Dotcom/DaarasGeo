<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarteController extends Controller
{
    function index()
    {
        return view('cartes.index');
    }
}
