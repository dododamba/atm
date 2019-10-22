<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Resource   CategorieContribuable
|
|
|
|*/


class CategorieContribuable extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

        'libelle'=>$this->libelle,'description'=>$this->description
        
        ];
    }

     /* --Generated with ❤ by Slugger ---*/

}
