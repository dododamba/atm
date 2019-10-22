<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Model   Contribuable
|
|
|
|*/



class Contribuable extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contribuables';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matricule',
       'num_piece_id', 
       'nom', 
       'prenoms', 
       'situation_matri', 
       'nb_enfants', 
       'nb_femmes', 
       'date_naissance', 
       'pays_residence', 
       'ville_residence', 
       'adresse', 
       'tel',
        'email', 
        'fonction',
         'service_direction', 'is_fonctionnaire', 'is_corp_habille', 'is_enseignant', 'salaire','categorie','slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getCategorie()
    {
        return $this->hasOne(CategorieContribuable::class, 'id', 'categorie');
    }

 /* --Generated with ❤ by Slugger ---*/


}
