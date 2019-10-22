<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Resource   Proprietaire
|
|
|
|*/


class Proprietaire extends Resource
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

        'nom'=>$this->nom,'prenom'=>$this->prenom,'naisssance'=>$this->naisssance,'nationalite'=>$this->nationalite,'adresse'=>$this->adresse,'num_piece_id'=>$this->num_piece_id,'nature_piece_id'=>$this->nature_piece_id,'tel'=>$this->tel,'naissance'=>$this->naissance,'slug'=>$this->slug
        
        ];
    }

     /* --Generated with ❤ by Slugger ---*/

}
