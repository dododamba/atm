<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Model   Proprietaire
|
|
|
|*/



class Proprietaire extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proprietaires';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'prenom', 'naisssance', 'nationalite', 'adresse', 'num_piece_id', 'nature_piece_id', 'tel', 'naissance', 'slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

 /* --Generated with ❤ by Slugger ---*/


}
