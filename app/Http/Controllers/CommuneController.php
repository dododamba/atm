<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Commune as CommuneResource;
use App\Commune;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   CommuneController
|
|
|
|*/


class CommuneController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!CommuneResource::collection(Commune::paginate(10))->isEmpty()){
                  return response()->json(['content'=>CommuneResource::collection(Commune::paginate(10)),'message'=>'list of Communes'],200,['Content-Type'=>'application/json']);
              }
              return response()->json(['message'=>'Communes empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      $data = [

          'nom_commune' =>$request->nom_commune,
          'logo' =>$request->nom_commune.'-'.time(),
          'code_commune' =>$request->code_commune,
          'adresse' =>$request->adresse,
          'contact' =>$request->contact,
          'responsable_communal' =>$request->responsable_communal,
          'hotel' =>$request->hotel,
          'coord_geo'=>$request->longitude,
          'latitude'=>$request->latitude,
          'slug' => str_slug(name_generator('hotel', 10), '-')
      ];





      $rules = [
          'nom_commune' => 'required|string|min:2|max:100',
          'code_commune' => 'required|string|min:2|max:100',
          'responsable_communal' => 'required|numeric',
          'hotel' => 'required|numeric',
          'contact' => 'required|string|min:2|max:100',
          'adresse' => 'required|string|min:2|max:1000',
          //  'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

      ];

      $messages = [
          'nom_commune.required' => 'Le champ nom hotel est obligatoire !',
          'nom_commune.string' => 'Le champ nom hotel doit contenir des chaines de charactères !',
          'nom_commune.min' => 'Le champ nom hotel doit contenir au moins deux charactères !',
          'nom_commune.max' => 'Le champ nom hotel ne doit pas exceder 100 charactères !',
          'code_commune.required' => 'Le champ code_commune est obligatoire !',
          'code_commune.string' => 'Le champ code_commune doit contenir des chaines de charactères !',
          'code_commune.min' => 'Le champ code_commune doit contenir au moins deux charactères !',
          'code_commune.max' => 'Le champ code_commune ne doit pas exceder 100 charactères !',
          'responsable_communal.required' => 'Le champ responsable communal  est obligatoire !',
          'responsable_communal.string' => 'Le responsable communal que vous avez choisi est invalide ou n\'existe pas!',
          'hotel.required' => 'Le champ hotel est obligatoire !',
          'hotel.string' => 'L\'hotel de ville que vous avez choisi est invalide ou n\'existe pas!',
          'contact.required' => 'Le champ contact est obligatoire !',
          'contact.string' => 'Le champ contact doit contenir des chaines de charactères !',
          'contact.min' => 'Le champ contact doit contenir au moins deux charactères !',
          'contact.max' => 'Le champ contact ne doit pas exceder 100 charactères !',
          'adresse.required' => 'Le champ adresse est obligatoire !',
          'adresse.string' => 'Le champ adresse doit contenir des chaines de charactères !',
          'adresse.min' => 'Le champ adresse doit contenir au moins deux charactères !',
          'adresse.max' => 'Le champ adresse ne doit pas exceder 100 charactères !',
          'coord_geo.required' => 'Le champ longitude est obligatoire !',
          'coord_geo.string' => 'Le champ longitude doit contenir des chaines de charactères !',
          'coord_geo.min' => 'Le champ longitude doit contenir au moins deux charactères !',
          'coord_geo.max' => 'Le champ longitude ne doit pas exceder 100 charactères !',
          'latitude.required' => 'Le champ latitude est obligatoire !',
          'latitude.string' => 'Le champ latitude doit contenir des chaines de charactères !',
          'latitude.min' => 'Le champ latitude doit contenir au moins deux charactères !',
          'latitude.max' => 'Le champ latitude ne doit pas exceder 100 charactères !',
          'logo.image' => 'Le  logo doit etre une image !',
          'logo.max' => 'Le  logo que vous avez choisi est trop lourd, veuillez choisir une autre image !',
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()) {
          return response()->json(
              [
                  'content' => [
                      'error' => $validator->errors(),
                      'status' => 0,
                      'message' => 'Le formulaire contient des erreurs, veuillez les corriger !'
                  ]
              ]
          );
      }


      if (Commune::create($data)) {


          return response()->json(
              [
                  'content' => [
                      'error' => null,
                      'status' => 1,
                      'message' => 'Hotel enregistré avec succès !'
                  ]
              ]
          );

      }

      return response()->json(
          [
              'content' => [
                  'error' => null,
                  'status' => 0,
                  'message' => 'Echec de création Hotel !'
              ]
          ]
      );
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   *
   * @return Response
   */
  public function show(Request $request,$slug)
   {
          if (Commune::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new CommuneResource(Commune::where('slug','=',$slug)->first()),'message'=>'detail Commune'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,Commune does not exist'],404,['Content-Type'=>'application/json']);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $slug
   *
   * @return Response
   */
  public function update(Request $request,$slug)
  {
        if (Commune::where('slug','=',$slug)->first()){
         $commune = Commune::where('slug','=',$slug)->first();
         if ($commune->update($request->all())){
             $commune =Commune::where('slug','=',$slug)->first();
             return response()->json(['message' => ' Commune updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' Commune does not exist !'],404,['Content-Type'=>'application/json']);
   }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $slug
   *
   * @return Response
   */
  public function destroy(Request $request,$slug)
   {
            if (Commune::where('slug','=',$slug)->first()){
                  $commune = Commune::where('slug','=',$slug)->first();
                  $commune->delete();
                  return response()->json(['message' => ' Commune deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' Commune does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
