<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Resource   Contribuable
|
|
|
|*/


class Contribuable extends Resource
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

        'matricule'=>$this->matricule,'num_piece_id'=>$this->num_piece_id,'nom'=>$this->nom,'prenoms'=>$this->prenoms,'situation_matri'=>$this->situation_matri,'nb_enfants'=>$this->nb_enfants,'nb_femmes'=>$this->nb_femmes,'date_naissance'=>$this->date_naissance,'pays_residence'=>$this->pays_residence,'ville_residence'=>$this->ville_residence,'adresse'=>$this->adresse,'tel'=>$this->tel,'email'=>$this->email,'fonction'=>$this->fonction,'service_direction'=>$this->service_direction,'is_fonctionnaire'=>$this->is_fonctionnaire,'is_corp_habille'=>$this->is_corp_habille,'is_enseignant'=>$this->is_enseignant,
        'salaire'=>$this->salaire,
        'categorie'=> new CategorieContribuable($this->getCategorie),
        'slug'=>$this->slug,
        'created_at'=>$this->created_at
        ];
    }

     /* --Generated with ❤ by Slugger ---*/

}
