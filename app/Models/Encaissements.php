<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Encaissements extends Model
{
    //

    protected $table = "encaissements";
    protected $primaryKey = "idEncaissement";

    public static function ca_jour($date_jour)
    {
    	return Encaissements::where("simpledateEnc","=",$date_jour)->sum("montantEnc");

    }


     public static function ca_mois($d)
    {
    	
    	$ca_mois = DB::table('encaissements')
                     ->select(DB::raw('sum(montantEnc) as ca_mois'))
                     ->whereRaw("MONTH(dateEnc) = MONTH('$d')")
                     ->get();

    	return $ca_mois;
    }

    public static function ca_by_taxe($d)
    {
        $ca_by_taxe = DB::table('encaissements')
                     ->leftJoin("taxes","encaissements.idTaxe","=","taxes.id")
                     ->selectRaw("taxes.id,taxes.libelle_taxe,taxes.categorie,taxes.code_taxe,sum(encaissements.montantEnc) as montant")
                     ->whereRaw("MONTH(dateEnc) = MONTH('$d')")
                     ->groupBy('taxes.id','taxes.libelle_taxe','taxes.categorie','taxes.code_taxe')->get();
         return $ca_by_taxe;
    }


    public static function ca_by_cat($d)
    {
    	$ca_by_taxe = DB::table('encaissements')
                     ->leftJoin("taxes","encaissements.idTaxe","=","taxes.id")
    				 ->leftJoin("categorietaxes","taxes.categorie","=","categorietaxes.id")
    				 ->selectRaw("categorietaxes.id,categorietaxes.libelle,taxes.categorie,sum(encaissements.montantEnc) as montant")
                     ->whereRaw("MONTH(dateEnc) = MONTH('$d')")
                     ->groupBy(['id'=>'categorietaxes.id','libelle'=>'categorietaxes.libelle','categorie'=>'taxes.categorie'])->get();
         return $ca_by_taxe;
    }



}
