<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\CategorieContribuable as CategorieContribuableResource;
use App\CategorieContribuable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   CategorieContribuableController
|
|
|
|*/


class CategorieContribuableController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!CategorieContribuableResource::collection(CategorieContribuable::paginate(10))->isEmpty()){
                  return response()->json(['content'=>CategorieContribuable::orderBy('created_at','desc')->paginate(10),'message'=>'list of CategorieContribuables'],200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'CategorieContribuables empty !']);

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
        //'slug' => str_slug(name_generator('categorie-article', 10), '-'),
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


    if (CategorieContribuable::create($data)) {
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
          if (CategorieContribuable::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new CategorieContribuableResource(CategorieContribuable::where('slug','=',$slug)->first()),'message'=>'detail CategorieContribuable'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,CategorieContribuable does not exist'],404,['Content-Type'=>'application/json']);
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
        if (CategorieContribuable::where('slug','=',$slug)->first()){
         $categoriecontribuable = CategorieContribuable::where('slug','=',$slug)->first();
         if ($categoriecontribuable->update($request->all())){
             $categoriecontribuable =CategorieContribuable::where('slug','=',$slug)->first();
             return response()->json(['message' => ' CategorieContribuable updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' CategorieContribuable does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (CategorieContribuable::where('slug','=',$slug)->first()){
                  $categoriecontribuable = CategorieContribuable::where('slug','=',$slug)->first();
                  $categoriecontribuable->delete();
                  return response()->json(['message' => ' CategorieContribuable deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' CategorieContribuable does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
