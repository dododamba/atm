<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Resource   Pay
|
|
|
|*/


class Pay extends Resource
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

        'libelle'=>$this->libelle,'pays'=>$this->pays,'indicatif'=>$this->indicatif,'iso'=>$this->iso,'slug'=>$this->slug
        
        ];
    }

     /* --Generated with ❤ by Slugger ---*/

}
