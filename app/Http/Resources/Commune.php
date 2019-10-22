<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Resource   Commune
|
|
|
|*/


class Commune extends Resource
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

            'id' => $this->id,
            'code_commune'=>$this->code_commune,
            'nom_commune'=>$this->nom_commune,
            'contact'=>$this->contact,
            'adresse'=>$this->adresse,
            'coord_geo'=>$this->coord_geo,
            'latitude'=>$this->latitude,
            'responsable_communal'=> new User($this->getResponsable),
            'hotel'=>new Hotel($this->getHotel),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),

        
        ];
    }

     /* --Generated with ❤ by Slugger ---*/

}
