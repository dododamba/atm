<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Taxe as TaxeResource;
use App\Taxe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   TaxeController
|
|
|
|*/


class TaxeController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

        if(!TaxeResource::collection(Taxe::paginate(10))->isEmpty()){
            return response()->json(['content'=>TaxeResource::collection(Taxe::orderBy('created_at','desc')->paginate(10)),'message'=>'list of Taxes'],200,['Content-Type'=>'application/json']);

        }
        return response()->json(['message'=>'Taxes empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    $data = [
        'code_taxe' => $request->code_taxe,
        'libelle_taxe' => $request->libelle_taxe,
        'categorie' => $request->categorie,
        'slug' => str_slug(name_generator('taxe', 50), '-'),
    ];
    

    $assert_false = 0;
    $assert_true = 1;

    $rules = [
        'code_taxe' => 'required|string|min:2|max:1000',
        'libelle_taxe' => 'required|string|min:2|max:1000',
        'categorie' => '',

    ];

    $messages = [
        'code_taxe.required' => 'Le champ code taxe est obligatoire !',
        'code_taxe.string' => 'Le champ code taxe doit contenir des chaines de charactères !',
        'code_taxe.min' => 'Le champ code taxe doit contenir au moins deux charactères !',
        'code_taxe.max' => 'Le champ code taxe ne doit pas exceder 1000 charactères !',
        'libelle_taxe.required' => 'Le champ libelle_taxe est obligatoire !',
        'libelle_taxe.string' => 'Le champ libelle_taxe doit contenir des chaines de charactères !',
        'libelle_taxe.min' => 'Le champ libelle_taxe doit contenir au moins deux charactères !',
        'libelle_taxe.max' => 'Le champ libelle_taxe ne doit pas exceder 1000 charactères !',
        'categorie.required' => 'Le champ catégorie taxe est obligatoire !',

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


    if (Taxe::create($data)) {
        // createLog(CategorieArticle::class);
        return response()->json(
            [
                'content' => [
                    'error' => null,
                    'status' => 1,
                    'message' => 'Catégorie enregistré avec succès !'
                ]
            ]
        );

    }

    return response()->json(
        [
            'content' => [
                'error' => null,
                'status' => 0,
                'message' => 'Echec de création catégorie !'
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
          if (Taxe::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new TaxeResource(Taxe::where('slug','=',$slug)->first()),'message'=>'detail Taxe'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,Taxe does not exist'],404,['Content-Type'=>'application/json']);
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
        if (Taxe::where('slug','=',$slug)->first()){
         $taxe = Taxe::where('slug','=',$slug)->first();
         if ($taxe->update($request->all())){
             $taxe =Taxe::where('slug','=',$slug)->first();
             return response()->json(['message' => ' Taxe updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' Taxe does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (Taxe::where('slug','=',$slug)->first()){
                  $taxe = Taxe::where('slug','=',$slug)->first();
                  $taxe->delete();
                  return response()->json(['message' => ' Taxe deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' Taxe does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
