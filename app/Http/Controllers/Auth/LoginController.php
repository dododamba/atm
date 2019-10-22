<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Sentinel;
use Illuminate\Http\Request;
use Activation;
use Redirect;
use Session;
use Illuminate\Support\Facades\Input;
use Mail;
use Carbon\Carbon;
use Mailchimp;
use App\ZipCode;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

   use  ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function login(Request $request)
    {


        try {

            // Validation
            $validation = Validator::make(['email'=>$request->email, 'password'=>$request->password], [
                'email' => 'required',
                'password' => 'required'
            ], [
//                'email.required' => 'Entrez une adresse email !',
                'email.email' => 'Entrez une adresse email valide !',
                'password.required' => 'Entrez votre mot de pass !',
            ]);

            if ($validation->fails()) {
                return Redirect::back()->withErrors($validation)->withInput();
            }



            $remember = (Input::get('remember') == 'on') ? true : false;
            if ($user = Sentinel::authenticate(['matricule'=>$request->email, 'password'=>$request->password], $remember)) {

                $access = Sentinel::getUser()->access_grant;

                    return redirect('dashboard');

           //    $this->access_token['token'] =   Sentinel::getUser()->createToken('Barer')->accessToken;


            }

            return Redirect::back()->withErrors(['global' => 'Mot de pass ou email non invalide !' ]);

        } catch (NotActivatedException $e) {
            return Redirect::back()->withErrors(['global' => 'Ce compte existe mais n\'a pas été activé !','activate_contact'=>1]);

        }
        catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            return Redirect::back()->withErrors(['global' => 'Vous été suspendu temporairement !' .' '. $delay .' seconds','activate_contact'=>1]);
        }

        return Redirect::back()->withErrors(['global' => 'Problème de connexion veuillez contacter les administrateurs']);


    }


    public function getAccessToken()
    {

        $token = $this->access_token;
        return response()->json(['token'=>$token]);

    }
    protected function logout()
    {
        Sentinel::logout();
        return redirect('/');
    }
    protected function activate($id){
        $user = Sentinel::findById($id);

        $activation = Activation::create($user);
        $activation = Activation::complete($user, $activation->code);

        $m = trans('messages.activation');
        Alert::info('Info', $m);


        return redirect('login');
    }

}
