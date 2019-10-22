<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Contribuable as ContribuableResource;
use App\Contribuable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ContribuableController
|
|
|
|*/


class ContribuableController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!ContribuableResource::collection(Contribuable::paginate(10))->isEmpty()){
                  return response()->json(['content'=>Contribuable::orderBy('created_at','desc')->paginate(10),'message'=>'list of Contribuables'],200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'Contribuables empty !']);

  }


  public function storeFromSession()
  {
     $data = session()->get('data');
     dd($data);
  }



  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {

    
    $data = [

        'chiffre_affaire' => $request->chiffre_affaire, 
        'capitale' => $request->capitale, 
        'categorie' => $request->categorie, 
        'nom_proprietaire' => $request->nom_partenaire, 
        'prenom_proprietaire' => $request->prenom_proprietaire, 
        'num_piece_id_proprietaire' => $request->num_piece_id_proprietaire, 
        'nationalite_proprietaire' => $request->nationalite_proprietaire, 
        'nature_piece_id_proprietaire' => $request->nature_piece_id_proprietaire, 
        'adresse_proprietaire' => $request->adresse_proprietaire, 
        'telephone_proprietaire' => $request->telephone_proprietaire, 
        'nom_gerant' => $request->nom_gerant, 
        'prenom_gerant' => $request->prenom_gerant, 
        'nationalite_gerant' => $request->nationalite_gerant, 
        'num_piece_id_gerant' => $request->num_piece_id_gerant, 
        'nature_piece_id_gerant' => $request->nature_piece_id_gerant, 
        'adresse_gerant' => $request->adresse_gerant, 
        'telephone_gerant' => $request->telephone_gerant, 
        'adresse_activite' => $request->adresse_activite, 
        'telephone_activite' => $request->telephone_activite, 
        'email_activite' => $request->email_activite, 
        'ville_activite' => $request->ville_activite,
        'lng' => $request->lng, 
        'lat' => $request->lat 
 
    ];


    return view('contribualbes.recap',compact('data'));



    /* $data = [
        'matricule' => $request->matricule, 
        'num_piece_id' => $request->num_piece_id,
        'nom' => $request->nom, 
        'prenoms' => $request->prenoms,
        'situation_matri' => $request->situation_matri,
        'nb_enfants' => $request->nb_enfants, 
        'nb_femmes' => $request->nb_femmes, 
        'date_naissance' => $request->date_naissance, 
        'pays_residence' => $request->pays_residence,
        'ville_residence' => $request->ville_residence, 
        'adresse' => $request->adresse,
        'tel' => $request->tel,
        'email' => $request->email,
        'fonction' => $request->fonction,
        'service_direction' => $request->service_direction,
        'is_fonctionnaire' => $request->is_fonctionnaire, 
        'is_corp_habille' => $request->is_corp_habille, 
        'is_enseignant' => $request->is_enseignant, 
        'salaire' => $request->salaire,
        'categorie' => $request->categorie,
        'slug' => str_slug(name_generator('categorie-article', 10), '-'),
    ];

    $assert_false = 0;
    $assert_true = 1;

    $rules = [
        'num_piece_id' => 'required|string|min:2|max:100',
        'nom' => 'required|string|min:2|max:100',
        'prenoms' => 'required|string|min:2|max:100',
        'categorie' => 'required',
        'date_naissance' => 'required|date',
        'fonction' => 'required|string|min:2|max:100',



    ];

    $messages = [
        'num_piece_id.required' => 'Le champ N° de pièce est obligatoire !',
        'num_piece_id.string' => 'Le champ N° de pièce doit contenir des chaines de charactères !',
        'num_piece_id.min' => 'Le champ N° de pièce doit contenir au moins deux charactères !',
        'num_piece_id.max' => 'Le champ N° de pièce ne doit pas exceder 100 charactères !',
        'nom.required' => 'Le champ nom est obligatoire !',
        'nom.string' => 'Le champ nom doit contenir des chaines de charactères !',
        'nom.min' => 'Le champ nom doit contenir au moins deux charactères !',
        'nom.max' => 'Le champ nom ne doit pas exceder 100 charactères !',
        'prenoms.required' => 'Le champ prenom est obligatoire !',
        'prenoms.string' => 'Le champ prenom doit contenir des chaines de charactères !',
        'prenoms.min' => 'Le champ prenom doit contenir au moins deux charactères !',
        'prenoms.max' => 'Le champ prenom ne doit pas exceder 100 charactères !',
        'categorie.required' => 'Le champ categorie est obligatoire !',
        'date_naissance.required' => 'Le champ date de naissance est obligatoire !',
        'date_naissance.date' => 'Le champ date de naissance doit etre de une date!',
        'fonction.required' => 'Le champ fonction est obligatoire !',
        'fonction.string' => 'Le champ fonction doit contenir des chaines de charactères !',
        'fonction.min' => 'Le champ fonction doit contenir au moins deux charactères !',
        'fonction.max' => 'Le champ fonction ne doit pas exceder 100 charactères !',
    ];

  /*  $validator = Validator::make($request->all(), $rules, $messages);

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
        if (Contribuable::create($data)) {
            // createLog(CategorieArticle::class);
            return response()->json(
                [
                    'content' => [
                        'error' => null,
                        'status' => 1,
                        'message' => 'Contribuable enregistré avec succès !'
                    ]
                ]
            );
    
        }
    
        return response()->json(
            [
                'content' => [
                    'error' => null,
                    'status' => 0,
                    'message' => 'Echec de création de Contribuable !'
                ]
            ]
        );*/
 
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
          if (Contribuable::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new ContribuableResource(Contribuable::where('slug','=',$slug)->first()),'message'=>'detail Contribuable'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,Contribuable does not exist'],404,['Content-Type'=>'application/json']);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $slug
   *
   * @return Response
   */
  public function update(Request $request)
  {
        if (Contribuable::where('slug','=',$slug)->first()){
         $contribuable = Contribuable::where('slug','=',$slug)->first();
         if ($contribuable->update($request->all())){
             $contribuable =Contribuable::where('slug','=',$slug)->first();
             return response()->json(['message' => ' Contribuable updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' Contribuable does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (Contribuable::where('slug','=',$slug)->first()){
                  $contribuable = Contribuable::where('slug','=',$slug)->first();
                  $contribuable->delete();
                  return response()->json(['message' => ' Contribuable deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' Contribuable does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
