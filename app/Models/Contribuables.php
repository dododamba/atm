<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contribuables extends Model
{
    //
    protected $table = "contribuables";

    protected $primaryKey = "idContribuable";


    public function categoriesContribuable(){
        return $this->belongsToMany("App\Models\CategorieContribuables","contribuablecatcontribuables","id_contribuable","id_cat")->withTimestamps();
    }

    public static function findContribuable($searchValue)
    {
        $response =  DB::table('Contribuables')->where('matricule','like',"%$searchValue%")
            ->orWhere('tel','like',"%$searchValue%")
            ->orWhere('nom','like',"%$searchValue%")
            ->orWhere('prenoms','like',"%$searchValue%")
            ->orWhere('adresse','like',"%$searchValue%")
            ->orWhere('email','like',"%$searchValue%")->get();

        return $response;
    }



}
