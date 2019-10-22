<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Resources\Pay as PayResource;
use App\Pay;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   PaysController
|
|
|
|*/


class PaysController extends Controller
{

/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

              if(!PayResource::collection(Pay::paginate(10))->isEmpty()){
                  return response()->json(['content'=>Pay::orderBy('created_at','desc')->paginate(10),'message'=>'list of Pays'],200,['Content-Type'=>'application/json']);

              }
              return response()->json(['message'=>'Pays empty !']);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
     if (Pay::create($request->all())) {
                return response()->json(['message' => ' Pay stored successful'],200,['Content-Type'=>'application/json']);

            }
     return response()->json(['message'=>'store Pay failed !']);
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
          if (Pay::where('slug','=',$slug)->first()){
          return response()->json(['content'=>new PayResource(Pay::where('slug','=',$slug)->first()),'message'=>'detail Pay'],200,['Content-Type'=>'application/json']);
          }

        return response()->json(['message' => 'echec ,Pay does not exist'],404,['Content-Type'=>'application/json']);
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
        if (Pay::where('slug','=',$slug)->first()){
         $pay = Pay::where('slug','=',$slug)->first();
         if ($pay->update($request->all())){
             $pay =Pay::where('slug','=',$slug)->first();
             return response()->json(['message' => ' Pay updated successful !'],200,['Content-Type'=>'application/json']);
         }else{
        return response()->json(['message' => ' updated failed  !'],400,['Content-Type'=>'application/json']);
     }

     }

    return response()->json(['message' => ' Pay does not exist !'],404,['Content-Type'=>'application/json']);
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
            if (Pay::where('slug','=',$slug)->first()){
                  $pay = Pay::where('slug','=',$slug)->first();
                  $pay->delete();
                  return response()->json(['message' => ' Pay deleted successful'],200,['Content-Type'=>'application/json']);
             }

       return response()->json(['message' => ' Pay does not exist !'],404,['Content-Type'=>'application/json']);
   }

 /* --Generated with ❤ by slugger---*/

}
