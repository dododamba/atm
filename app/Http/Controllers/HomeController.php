<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encaissements;
use App\Models\Contribuables;

class HomeController extends Controller
{
    public function home($value='')
    {
    	return view('auth.login');
    }
    public function YourhomePage($value='')
    {
    	return view('home');
    }
    public function dashboard($value='')
    {
        $ca_jours = Encaissements::ca_jour(date("Y-m-d"));
        $ca_mois = Encaissements::ca_mois(date("Y-m-d"))[0]->ca_mois;
        $total_contribuables = Contribuables::where("deleted_at",null)->orderBy("id")->get()->count();
        $ca_by_taxe = Encaissements::ca_by_taxe(date("Y-m-d"));
        $ca_by_cat = Encaissements::ca_by_cat(date("Y-m-d"));
    	return view('dashboard', compact("ca_jours","ca_mois","total_contribuables","ca_by_taxe","ca_by_cat"));
    }

}
