<?php

namespace App\Http\Controllers;

use App\CategorieTaxe;
use App\Http\Controllers\Controller;

use App\Http\Resources\Hotel as HotelResource;
use App\Http\Resources\User as UserResource;
use App\Hotel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
|
| Controller   HotelController
|
|
|
|*/


class HotelController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        if (!HotelResource::collection(Hotel::paginate(10))->isEmpty()) {
            return response()->json(['content' => HotelResource::collection(Hotel::paginate(10)), 'message' => 'list of Hotels'], 200, ['Content-Type' => 'application/json']);

        }
        return response()->json(['message' => 'Hotels empty !']);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
          $logo = $request->logo;
      //    $extension = $logo->getClientOriginalName();



        $data = [

            'nom_hotel' =>$request->nom_hotel,
            'logo' =>$request->nom_hotel.'-'.time(),
            'ville' =>$request->ville,
            'adresse' =>$request->adresse,
            'contact' =>$request->contact,
            'responsable' =>$request->responsable,
            'longitude'=>$request->longitude,
            'latitude'=>$request->latitude,
             'slug' => str_slug(name_generator('hotel', 10), '-')
        ];





        $rules = [
            'nom_hotel' => 'required|string|min:2|max:100',
            'ville' => 'required|string|min:2|max:100',
            'responsable' => 'required|numeric',
            'contact' => 'required|string|min:2|max:100',
            'adresse' => 'required|string|min:2|max:1000',
          //  'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];

        $messages = [
            'nom_hotel.required' => 'Le champ nom hotel est obligatoire !',
            'nom_hotel.string' => 'Le champ nom hotel doit contenir des chaines de charactères !',
            'nom_hotel.min' => 'Le champ nom hotel doit contenir au moins deux charactères !',
            'nom_hotel.max' => 'Le champ nom hotel ne doit pas exceder 100 charactères !',
            'ville.required' => 'Le champ ville est obligatoire !',
            'ville.string' => 'Le champ ville doit contenir des chaines de charactères !',
            'ville.min' => 'Le champ ville doit contenir au moins deux charactères !',
            'ville.max' => 'Le champ ville ne doit pas exceder 100 charactères !',
            'responsable.required' => 'Le champ responsable  est obligatoire !',
            'responsable.string' => 'Le responsable que vous avez choisi est invalide ou n\'existe pas!',
            'contact.required' => 'Le champ contact est obligatoire !',
            'contact.string' => 'Le champ contact doit contenir des chaines de charactères !',
            'contact.min' => 'Le champ contact doit contenir au moins deux charactères !',
            'contact.max' => 'Le champ contact ne doit pas exceder 100 charactères !',
            'adresse.required' => 'Le champ adresse est obligatoire !',
            'adresse.string' => 'Le champ adresse doit contenir des chaines de charactères !',
            'adresse.min' => 'Le champ adresse doit contenir au moins deux charactères !',
            'adresse.max' => 'Le champ adresse ne doit pas exceder 100 charactères !',
            'longitude.required' => 'Le champ longitude est obligatoire !',
            'longitude.string' => 'Le champ longitude doit contenir des chaines de charactères !',
            'longitude.min' => 'Le champ longitude doit contenir au moins deux charactères !',
            'longitude.max' => 'Le champ longitude ne doit pas exceder 100 charactères !',
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


        if (Hotel::create($data)) {

          //  $logo->move(public_path('images/logo'), $data['logo']);


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
     * @param int $id
     *
     * @return Response
     */
    public function show(Request $request, $slug)
    {
        if (Hotel::where('slug', '=', $slug)->first()) {
            return response()->json(['content' => new HotelResource(Hotel::where('slug', '=', $slug)->first()), 'message' => 'detail Hotel'], 200, ['Content-Type' => 'application/json']);
        }

        return response()->json(['message' => 'echec ,Hotel does not exist'], 404, ['Content-Type' => 'application/json']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param int $slug
     *
     * @return Response
     */
    public function update(Request $request,$slug)
    {
        if (Hotel::where('slug', '=', $slug)->first()) {
            $hotel = Hotel::where('slug', '=', $slug)->first();
            if ($hotel->update($request->all())) {
                $hotel = Hotel::where('slug', '=', $slug)->first();
                return response()->json(['message' => ' Hotel updated successful !'], 200, ['Content-Type' => 'application/json']);
            } else {
                return response()->json(['message' => ' updated failed  !'], 400, ['Content-Type' => 'application/json']);
            }

        }

        return response()->json(['message' => ' Hotel does not exist !'], 404, ['Content-Type' => 'application/json']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $slug
     *
     * @return Response
     */
    public function destroy(Request $request, $slug)
    {
        if (Hotel::where('slug', '=', $slug)->first()) {
            $hotel = Hotel::where('slug', '=', $slug)->first();
            $hotel->delete();
            return response()->json(['message' => ' Hotel deleted successful'], 200, ['Content-Type' => 'application/json']);
        }

        return response()->json(['message' => ' Hotel does not exist !'], 404, ['Content-Type' => 'application/json']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function responsable()
    {

        if (!UserResource::collection(User::paginate(10))->isEmpty()) {
            return response()->json(['content' => User::orderBy('created_at', 'desc')->paginate(10), 'message' => 'list des employees'], 200, ['Content-Type' => 'application/json']);

        }
        return response()->json(['message' => 'Hotels empty !']);

    }

    /* --Generated with ❤ by slugger---*/

}
