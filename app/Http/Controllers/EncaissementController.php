<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Sentinel;
use Validator;
use App\ModelsEmployes;
use App\Models\Encaisssements;
use App\Models\Taxes;


class EncaissementController extends Controller
{
    //

    public function __construct()
    {

    }

    public function nouvelEncaissement()
    {        
        return view('caisse.encaisser',['title'=>"Nouvel encaissement"]);
    }


    public function nouveauVersement()
    {        
        $listeAgents = ModelsEmployes::all();
        $listeTaxes = Taxes::all();
        return view('caisse.versement',['title'=>"Encaisser un versement","listeAgents"=>$listeAgents, "listeTaxes"=>$listeTaxes]);
    }

    public function enregistrerVersement(Request $request)
    {


        $data = [
            'idEmp' => $request->matricule, 
            'montantEnc' => $request->num_piece_id,
            'commentaires' => $request->nom, 
            'idTaxe' => $request->nom, 
        ];


        $rules = [
            'idEmp' => 'required|numeric',
            'idTaxe' => 'required|numeric',        
            'montantEnc' => 'required|numeric',        
        ];

        $messages = [
            'idEmp.required' => 'Veuillez choirir un agent de recouvrement',
            'montantEnc.required' => 'Veuillez saisir le montant',
            'idTaxe.required' => 'Veuillez saisir le montant'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(["errors"=>"Veuillez remplir correctement le formulaire"])->withInput();
        }else{
            $enc = new \App\Models\Encaissements();
            $enc->idTaxe = $request->idTaxe;
            $enc->idUser = Sentinel::getUser()->id;
            $enc->montantEnc = $request->montantEnc;
            $enc->simpledateEnc = date("Y-m-d");
            $enc->commentaire = $request->get("commentaires");
            $enc->idEmploye = $request->get("idEmp");

            $enc->save();
            return redirect()->back()->with(["success"=>"Enregistrement effectue avec succes"]);

        }


    }
    
    public function enregistrerEncaissement()
    {

    }

    public function listerEncaissements()
    {

        $listerEncaissements = \App\Models\Encaissements::all();
        return view('caisse.recette', compact("listerEncaissements"));

    }

}
