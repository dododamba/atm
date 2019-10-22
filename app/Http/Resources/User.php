<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
|
| Resource   User
|
|
|
|*/


class User extends Resource
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

        'matricule'=>$this->matricule,'nom'=>$this->nom,'prenom'=>$this->prenom,'date_naiss'=>$this->date_naiss,'fonction'=>$this->fonction,'email'=>$this->email,'password'=>$this->password,'slug'=>$this->slug,'langue'=>$this->langue,'telephone'=>$this->telephone,'permissions'=>$this->permissions,'remember_token'=>$this->remember_token,'role'=>$this->role,'reset_token'=>$this->reset_token,'last_login'=>$this->last_login
        
        ];
    }

     /* --Generated with ❤ by Slugger ---*/

}
