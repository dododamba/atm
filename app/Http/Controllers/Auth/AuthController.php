<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Validator;
use Sentinel;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AuthController
{
    use  ThrottlesLogins;

    public function login(Request $request)
    {


        try {

            // Validation
            $validation = Validator::make([ 'email' =>$request->username, 'password' =>$request->password], [
                'email' => 'required',
                'password' => 'required'
            ], [
                'email.required' => 'Entrez un nuero matricule valide !',
                //'email.email' => 'Entrez une adresse email valide !',
                'password.required' => 'Entrez votre mot de pass !',
            ]);

            if ($validation->fails()) {
                return response()->json(['errors' => $validation]);

            }


            $remember = (Input::get('remember') == 'on') ? true : false;
            if ($user = Sentinel::authenticate([ 'matricule' =>$request->username, 'password' =>$request->password], $remember)) {
            //if ($user = Sentinel::authenticate([ 'email' =>$request->username, 'password' =>$request->password], $remember)) {

                $user = Sentinel::getUser();
                $token = $user->createToken('Barer')->accessToken;

                return response()->json([
                                  'token' => $token,
                                  'user' => $user
                                 ], 200);]);

            }

            return response()->json(['errors' => 'Mot de pass ou email non invalide !']);


        } catch (NotActivatedException $e) {
            return response()->json(['errors' => 'Ce compte existe mais n\'a pas été activé !', 'activate_contact' => 1]);

        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            return response()->json(['errors' => 'Vous été suspendu temporairement !' . ' ' . $delay . ' seconds', 'activate_contact' => 1]);

        }


        return response()->json(['errors' => 'Problème de connexion veuillez contacter les administrateurs']);

    }


    public function getAccessToken()
    {

        $token = $this->access_token;
        return response()->json(['token' => $token]);

    }

    protected function logout()
    {
        Sentinel::logout();
        return redirect('/');
    }

    protected function activate($id)
    {
        $user = Sentinel::findById($id);

        $activation = Activation::create($user);
        $activation = Activation::complete($user, $activation->code);

        $m = trans('messages.activation');
        Alert::info('Info', $m);


        return redirect('login');
    }


    public function register()
    {
      $validation = Validator::make($request->all(), [
              'first_name' => 'required|string|max:255',
              'last_name' => 'required|string|max:255',
              'email' => 'required|string|email|max:255|unique:users',
              'password' => 'required|string|min:6|confirmed',
          ]);

       if ($validation->fails()) {
              return response()->json(['errors'=>$validation])
       }



       $role_ = \App\Role::where('name','=','Client')
                             ->first();


       $data_user = [
          'email'=>$request->email,
          'password'=>Hash::make($request->password),
          'slug'=>str_slug('client'.str_random(10),'-'),
          'langue'=>'Fr',
          'telephone' => '',
          'remember_token'=>str_slug(str_random(50),'_'),
          'role' => $role_->id
       ];
       $user = User::create($data_user);

       if (User::where('slug',$data_user['slug'])->first()) {
          $user_ = User::where('slug',$data_user['slug'])->first();
          $data = [
              'nom'=>$request->first_name,
              'prenom' =>$request->last_name,
              'slug' =>str_slug(name_generator('client',30),'_'),
              'user_id' =>$user_->id,
             ];

             Client::create($data);
             //Activate the user **
             // $activation = Activation::create($user);
             // $activation = Activation::complete($user, $activation->code);
            //End activation

      if($user){
          $user->roles()->sync([$role_->id]); // 2 = client

         return response()->json(['message'=>'Compte crée avec succès'])
      }
      return response()->json(['error'=>'Une erreur s\'est produit lors de la création du compte '])

       }

    }
}
