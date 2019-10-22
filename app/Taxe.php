<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Model   Taxe
|
|
|
|*/



class Taxe extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'taxes';
    

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['code_taxe', 'libelle_taxe','categorie','slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

 /* --Generated with ❤ by Slugger ---*/

   public function getCategorie()
   {
       return $this->hasOne(CategorieTaxe::class, 'id', 'categorie');
   }
}
