<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Model   Commune
|
|
|
|*/


class Commune extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'communes';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['code_commune', 'nom_commune', 'contact', 'adresse', 'coord_geo', 'latitude', 'responsable_communal','hotel'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function getResponsable()
    {
        return $this->hasOne(User::class, 'id', 'responsable_communal');
    }

    public function getHotel()
    {
        return $this->hasOne(Hotel::class, 'id', 'hotel');
    }
    /* --Generated with ❤ by Slugger ---*/


}
