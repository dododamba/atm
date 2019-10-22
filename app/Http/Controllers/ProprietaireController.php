<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Proprietaire as ProprietaireResource;
use App\Proprietaire;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   ProprietaireController
|
|
|
|*/


class ProprietaireController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!ProprietaireResource::collection(Proprietaire::paginate(10))->isEmpty()){
                  return response()->json(['content'=>Proprietaire::orderBy('created_at','desc')->paginate(10),'message'=>'list of Proprietaires'],200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'Proprietaires empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
     if (Proprietaire::create($request->all())) {
                return response()->json(['message' => ' Proprietaire stored successful'],200,['Content-Type'=>'application/json']);

            }
     return response()->json(['message'=>'store Proprietaire failed !']);
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
          if (Proprietaire::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new ProprietaireResource(Proprietaire::where('slug','=',$slug)->first()),'message'=>'detail Proprietaire'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,Proprietaire does not exist'],404,['Content-Type'=>'application/json']);
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
        if (Proprietaire::where('slug','=',$slug)->first()){
         $proprietaire = Proprietaire::where('slug','=',$slug)->first();
         if ($proprietaire->update($request->all())){
             $proprietaire =Proprietaire::where('slug','=',$slug)->first();
             return response()->json(['message' => ' Proprietaire updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' Proprietaire does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (Proprietaire::where('slug','=',$slug)->first()){
                  $proprietaire = Proprietaire::where('slug','=',$slug)->first();
                  $proprietaire->delete();
                  return response()->json(['message' => ' Proprietaire deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' Proprietaire does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
