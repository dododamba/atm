<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Nationalite as NationaliteResource;
use App\Nationalite;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   NationaliteController
|
|
|
|*/


class NationaliteController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!NationaliteResource::collection(Nationalite::paginate(10))->isEmpty()){
                  return response()->json(['content'=>Nationalite::orderBy('created_at','desc')->paginate(10),'message'=>'list of Nationalites'],200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'Nationalites empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
     if (Nationalite::create($request->all())) {
                return response()->json(['message' => ' Nationalite stored successful'],200,['Content-Type'=>'application/json']);

            }
     return response()->json(['message'=>'store Nationalite failed !']);
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
          if (Nationalite::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new NationaliteResource(Nationalite::where('slug','=',$slug)->first()),'message'=>'detail Nationalite'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,Nationalite does not exist'],404,['Content-Type'=>'application/json']);
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
        if (Nationalite::where('slug','=',$slug)->first()){
         $nationalite = Nationalite::where('slug','=',$slug)->first();
         if ($nationalite->update($request->all())){
             $nationalite =Nationalite::where('slug','=',$slug)->first();
             return response()->json(['message' => ' Nationalite updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' Nationalite does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (Nationalite::where('slug','=',$slug)->first()){
                  $nationalite = Nationalite::where('slug','=',$slug)->first();
                  $nationalite->delete();
                  return response()->json(['message' => ' Nationalite deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' Nationalite does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
