<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Resource   Taxe
|
|
|
|*/


class Taxe extends Resource
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

         'id'=>$this->id,
        'code_taxe'=>$this->code_taxe,
        'libelle_taxe'=>$this->libelle_taxe,
        'categorie'=>new CategorieTaxe($this->getCategorie),
        'slug'=>$this->slug,
        'created_at'=>$this->created_at


        
        ];
    }

     /* --Generated with ❤ by Slugger ---*/

}
