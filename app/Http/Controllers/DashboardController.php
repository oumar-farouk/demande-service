<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard',[
            'nbr_service' => 3,
            'nbr_citoyen' => 3,
            'nbr_demande' => 3,
        ]);
    }
}
