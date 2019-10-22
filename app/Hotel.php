<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Model   Hotel
|
|
|
|*/


class Hotel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hotels';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nom_hotel', 'logo', 'ville', 'adresse', 'contact', 'responsable', 'longitude', 'latitude'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /* --Generated with ❤ by Slugger ---*/

    public function getResponsable()
    {
        return $this->hasOne(User::class, 'id', 'responsable');
    }

}
