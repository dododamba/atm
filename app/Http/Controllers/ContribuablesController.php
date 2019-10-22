<?php

namespace App\Http\Controllers;

use App\Models\Contribuables;
use Validator;
use App\Models\CategorieContribuables;
use App\Models\Encaissements;
use App\Models\Taxes;
use Illuminate\Http\Request;
use Sesntinel;
class ContribuablesController extends Controller
{
    //
    public function findContribuable(Request $request)
    {
        $value = $request->get("searchval");

        if($value){
            return response()->json(Contribuables::findContribuable($value));
        }else{
            return response()->json(false);
        }
    }

    public function getTaxes(Request $request)
    {
        $value = $request->get("contribuable");
        $taxes = false;
        if($value){
            $categories = Contribuables::find($value)->categoriesContribuable;
            $taxes = $categories->first();
            if($taxes){
                $taxes = CategorieContribuables::find($taxes->id)->taxes->all();
                //$taxes = CategorieContribuables::find($taxes->id)->taxes()->get();
            }

        }else{
            $taxes = false;
        }

        return response()->json($taxes);
    }

    public function save(Request $request)
    {
        $d = [
            "idUser" => 'required',
            "idContribuable" => 'required',
            "montantEnc" => "required",
            "penalite" => "required",
        ];

        $request->merge(["idHotel" => 1]);
        $validator = Validator::make($request->all(),$d);
        
        if ($validator->fails()) {
            return response()->json(false);
        }else{

            $listTaxes = $request->get("idTaxe") != null ? explode(' ', $request->get("idTaxe")) : [] ;

            $enc = new Encaissements();
            $enc->idUser = $request->get("idUser");
            $enc->idContribuable = $request->get("idContribuable");
            $enc->idHotel = $request->get("idHotel");
            $enc->idTaxe = $request->get("idTaxe"); // A corriger <static>
            $enc->montantEnc = $request->get("montantEnc");
            $enc->simpledateEnc  = date('Y-m-d');
            $enc->penalite = $request->get("penalite");
            //$enc->idEmploye = Sentinel::getUser()->id;
            $enc->idEmploye = 1;
            $enc->save();
            
            $newIdEnc = $enc->idEncaissement;
            if(count($listTaxes)){
                /*foreach ($variable as $key => $value) {
                    $detail = new DetailsEncaissement();
                    $details->idTaxe = $value;
                    $details->idEncaissement = $newIdEnc;
                    Contribuable::find($enc->idContribuable)->id;
                    TaxesContribuables::where(['idTaxe'=>$value,"id_cat_contribuable"=>])
                }*/
            }else{

            }
            return response()->json(true);
        }

    }




}
