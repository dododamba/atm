<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Model   Pay
|
|
|
|*/



class Pay extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pays';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['libelle', 'pays', 'indicatif', 'iso', 'slug'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

 /* --Generated with ❤ by Slugger ---*/


}
