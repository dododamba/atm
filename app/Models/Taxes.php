<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxes extends Model
{
    //

    protected $table = "taxes";
    protected $primaryKey = "id";


    public function categoriesContribuables()
    {
    	 return $this->belongsToMany("App\Models\CategorieContribuables","taxecontribuable","idTaxe","id_cat_contribuable")->withPivot(["montant","taux","devise"])->withTimestamps();
    }
}
