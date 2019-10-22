<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Resource   Hotel
|
|
|
|*/


class Hotel extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom_hotel' => $this->nom_hotel,
            'logo' => $this->logo,
            'ville' => $this->ville,
            'adresse' => $this->adresse,
            'contact' => $this->contact,
            'employe_responsable' => new User($this->getResponsable),
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'slug' => $this->slug,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y'),



        ];
    }

    /* --Generated with ❤ by Slugger ---*/

}
