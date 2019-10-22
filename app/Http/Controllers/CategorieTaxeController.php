<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\CategorieTaxe as CategorieTaxeResource;
use App\CategorieTaxe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   CategorieTaxeController
|
|
|
|*/


class CategorieTaxeController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

               if(!CategorieTaxeResource::collection(CategorieTaxe::paginate(10))->isEmpty()){
                  return response()->json(['content'=>CategorieTaxe::orderBy('created_at','desc')->paginate(10),'message'=>'list of CategorieTaxes'],200,['Content-Type'=>'application/json']);

               }
               return response()->json(['message'=>'CategorieTaxes empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    $data = [
        'libelle' => $request->libelle,
        'description' => $request->description,
        'slug' => str_slug(name_generator('categorie-taxe', 10), '-'),
    ];

    $assert_false = 0;
    $assert_true = 1;

    $rules = [
        'libelle' => 'required|string|min:2|max:100',
        'description' => 'required|string|min:2|max:100',

    ];

    $messages = [
        'libelle.required' => 'Le champ libelle est obligatoire !',
        'libelle.string' => 'Le champ libelle doit contenir des chaines de charactères !',
        'libelle.min' => 'Le champ libelle doit contenir au moins deux charactères !',
        'libelle.max' => 'Le champ libelle ne doit pas exceder 100 charactères !',
        'description.required' => 'Le champ description est obligatoire !',
        'description.string' => 'Le champ description doit contenir des chaines de charactères !',
        'description.min' => 'Le champ description doit contenir au moins deux charactères !',
        'description.max' => 'Le champ description ne doit pas exceder 100 charactères !',

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


    if (CategorieTaxe::create($data)) {
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
          if (CategorieTaxe::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new CategorieTaxeResource(CategorieTaxe::where('slug','=',$slug)->first()),'message'=>'detail CategorieTaxe'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,CategorieTaxe does not exist'],404,['Content-Type'=>'application/json']);
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
        if (CategorieTaxe::where('slug','=',$slug)->first()){
         $categorietaxe = CategorieTaxe::where('slug','=',$slug)->first();
         if ($categorietaxe->update($request->all())){
             $categorietaxe =CategorieTaxe::where('slug','=',$slug)->first();
             return response()->json(['message' => ' CategorieTaxe updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' CategorieTaxe does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (CategorieTaxe::where('slug','=',$slug)->first()){
                  $categorietaxe = CategorieTaxe::where('slug','=',$slug)->first();
                  $categorietaxe->delete();
                  return response()->json(['message' => ' CategorieTaxe deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' CategorieTaxe does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
