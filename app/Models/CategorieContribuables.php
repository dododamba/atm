<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieContribuables extends Model
{
    //
    protected $table = "categoriecontribuables";
    protected $primaryKey = "idCat";


    public function contribuables()
    {
        return $this->belongsToMany("App\Models\Contribuables","contribuablecatcontribuables","id_cat","id_contribuable")->withTimestamps();

    }

    public function taxes()
    {

        return $this->belongsToMany("App\Models\Taxes","taxecontribuables","id_cat_contribuable","idTaxe")->withPivot(["montant","taux","devise"])->withTimestamps();
    }




}
