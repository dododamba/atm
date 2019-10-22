<?php

namespace App\Http\Controllers;

use App\Client;
use App\Commune;
use function foo\func;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Role;
use Validator;
use Session;
use Auth;
use Route;
use Activation;
use DB;
use Hash;
use Mail;
use Sentinel;
use Carbon\Carbon;
use App\Http\Resources\Client as ClientResource;


class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth')->except('orders');
        // $this->middleware('auth');
    }

    protected function validator(Request $request, $id = '')
    {
        return Validator::make($request->all(), [
            'nom' => 'required|min:2|max:35|string',
            'prenom' => 'required|min:2|max:35|string',
            'email' => Sentinel::inRole('Admin') ? 'required|email|min:3|max:50|string' : (Sentinel::check() ? 'required|email|min:3|max:50|string|unique:users,email,' . $id : 'required|email|min:3|max:50|unique:users|string'),
            'password' => 'min:6|max:50|confirmed',
            //'gender' => 'required',
            'role' => 'required',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->type;
        $users= User::all();
        if ($type) {
         $role = Sentinel::findRoleBySlug($type);
         $users = $role->users()->get();
        }
       
       return View('users.index', compact('users')); 
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function client()
    {
       // return View('users.client');

        dd('aliko');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createClient(Request $request)
    {

        $roles = Role::get()->pluck('name', 'id');
        $communes = Commune::get()->pluck('nom_commune', 'id');

        return View('users.create', compact('roles','communes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $roles = Role::get()->pluck('name', 'id');
        $communes = Commune::get()->pluck('nom_commune', 'id');

        return View('users.create', compact('roles','communes'));    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = [
            'matricule' =>$request->matricule,
            'nom' =>$request->nom,
            'prenom' =>$request->prenom,
            'date_naiss' =>$request->date_naiss,
            'fonction' =>$request->fonction,
            'langue' =>$request->langue,
            'telephone' =>$request->telephone,
            'remember_token' =>name_generator('remeber-token-atm',100),
            'reset_token' =>'',
            'last_login' =>'',
            'email' =>$request->email,
            'password' =>bcrypt($request->password),
            'slug' =>str_slug(name_generator('user',10),'-'),
            'langue' =>$request->langue,
            'telephone' =>$request->telephone,
            'permissions' =>'{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true}',
            'role'=>(integer)$request->role,
            'commune'=>(integer)$request->commune
        ];

     /*   if ($request->has('nomCaratere') && $request->has('valCaratere')) {
                 $nom_c = $request->nomCaratere;
                 $val_c = $request->valCaratere;

                 $i = 0;
                 foreach (array_combine($nom_c, $val_c) as $key => $value) {
                     $_data = [
                         'nom' => '' . $key . '' =>$request->,
                         'valeur' => '' . $value . '',
                     ];
                     $i++;
                 }

                 dd($nom_c,$val_c);

             }*/

        //create user
        $user = Sentinel::register($data);
        //activate user
        $activation = Activation::create($user);
        $activation = Activation::complete($user, $activation->code);
        //add role
         $user->roles()->sync([$request->role]);

        session()->flash('message', 'Success! User is created successfully.');
        session()->flash('status', 'success');

        return redirect()->route('user.index');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $type = $user->roles()->first();
        if ($request->is('api/*')) {
            $user = User::where('id', $id)->with('activations', 'roles')->get();
            return response()->json(compact('user'));
        }
        return View('users.show', compact('user', 'type'));
    }

    public function accountFrontEnd(Request $request, $id)
    {
        $user = Sentinel::getUser();
        if ($user->inRole('admin')) {
            $user = User::findOrFail($id);
            return view('frontend.userAcount', compact('user'));
        }

        return view('frontend.userAcount', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $roles = Role::get()->pluck('name', 'id');
        return View('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $update_user = Validator::make($request->all(), [
            'first_name' => 'min:2|max:35|string',
            'last_name' => 'min:2|max:35|string',
            'email' => Sentinel::inRole('Admin') ? 'required|email|min:3|max:50|string' : (Sentinel::check() ? 'required|email|min:3|max:50|string|unique:users,email,' . $id : 'required|email|min:3|max:50|unique:users|string'),
        ]);

        if ($update_user->fails()) {
            return redirect()->back()
                ->withErrors($update_user)
                ->withInput();
        }

        $user = User::find($id);
        if ($user) {

            if ($request->first_name) {
                $user->first_name = $request->first_name;
            }
            if ($request->last_name) {
                $user->last_name = $request->last_name;
            }
            if ($request->email) {
                $user->email = $request->email;
            }
            if ($request->new_password && $request->new_password_confirmation) {
                if ($request->new_password == $request->new_password_confirmation) {
                    $user->password = bcrypt($request->new_password);
                } else {
                    session()->flash('message', 'Your old password is incorrect.');
                    session()->flash('status', 'error');
                    return redirect()->back()->withErrors(['old_password', 'your old password is incorrect']);
                }
            }
            $user->update();
            if ($request->role) {
                $user->roles()->sync([$request->role]);
            }
            session()->flash('message', 'Success! User is updated successfully.');
            session()->flash('status', 'success');

        }


        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('message', 'Success! User is deleted successfully.');
        session()->flash('status', 'success');

        return redirect()->route('user.index');
    }

    public function permissions($id)
    {
        $user = Sentinel::findById($id);
        $routes = Route::getRoutes();


        //Api Route
        // $api = app('api.router');
        // /** @var $api \Dingo\Api\Routing\Router */
        // $routeCollector = $api->getRoutes(config('api.version'));
        // /** @var $routeCollector \FastRoute\RouteCollector */
        // $api_route = $routeCollector->getRoutes();


        $actions = [];
        foreach ($routes as $route) {
            if ($route->getName() != "" && !substr_count($route->getName(), 'payment')) {
                $actions[] = $route->getName();
            }
        }

        $input = preg_quote("store", '~');
        $var = preg_grep('~' . $input . '~', $actions);
        $actions = array_values(array_diff($actions, $var));

        $input = preg_quote("update", '~');
        $var = preg_grep('~' . $input . '~', $actions);
        $actions = array_values(array_diff($actions, $var));

        // foreach ($api_route as $route) {
        //     if ($route->getName() != "" && !substr_count($route->getName(), 'payment')) {
        //         $actions[] = $route->getName();
        //     }            
        // }

        $var = [];
        $i = 0;
        foreach ($actions as $action) {

            $input = preg_quote(explode('.', $action)[0] . ".", '~');
            $var[$i] = preg_grep('~' . $input . '~', $actions);
            $actions = array_values(array_diff($actions, $var[$i]));
            $i += 1;
        }

        $actions = array_filter($var);
        // dd (array_filter($actions));

        return View('users.permissions', compact('user', 'actions'));
    }

    public function save($id, Request $request)
    {
        //return $request->permissions;
        $user = Sentinel::findById($id);
        $user->permissions = [];
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                if (explode('.', $permission)[1] == 'create') {
                    $user->addPermission($permission);
                    $user->addPermission(explode('.', $permission)[0] . ".store");
                } else if (explode('.', $permission)[1] == 'edit') {
                    $user->addPermission($permission);
                    $user->addPermission(explode('.', $permission)[0] . ".update");
                } else {
                    $user->addPermission($permission);
                }
            }
        }

        $user->save();

        session()->flash('message', 'Success! Permissions are stored successfully.');
        session()->flash('status', 'success');

        return redirect()->route('user.index');
    }

    public function activate(Request $request, $id)
    {
        $user = Sentinel::findById($id);

        $activation = Activation::completed($user);

        if ($activation) {
            session()->flash('message', 'Warning! The user is already activated.');
            session()->flash('status', 'warning');

            return redirect('user');
        }
        $activation = Activation::create($user);
        $activation = Activation::complete($user, $activation->code);

        session()->flash('message', 'Success! The user is activated successfully.');
        session()->flash('status', 'success');

        $role = $user->roles()->first()->name;

        return redirect()->route('user.index');
    }

    public function deactivate(Request $request, $id)
    {

        $user = Sentinel::findById($id);
        Activation::remove($user);

        session()->flash('message', 'Success! The user is deactivated successfully.');
        session()->flash('status', 'success');

        return redirect()->route('user.index');
    }

    public function ajax_all(Request $request)
    {
        if ($request->action == 'delete') {
            foreach ($request->all_id as $id) {
                $user = User::findOrFail($id);
                if ($user->deleted_at == null) {
                    $user->delete();
                }
            }
            session()->flash('message', 'Success! Users are deleted successfully.');
            session()->flash('status', 'success');
            return response()->json(['success' => true, 'status' => 'Sucesfully Deleted']);
        }
        if ($request->action == 'deactivate') {
            foreach ($request->all_id as $id) {
                $user = User::findOrFail($id);
                $activation = Activation::completed($user);
                if ($activation) {
                    Activation::remove($user);
                }
            }
            session()->flash('message', 'Success! Users are deactivate successfully.');
            session()->flash('status', 'success');
            return response()->json(['success' => true, 'status' => 'Sucesfully deactivate']);
        }
        if ($request->action == 'activate') {
            foreach ($request->all_id as $id) {
                $user = User::findOrFail($id);
                $activation = Activation::completed($user);
                if ($activation == '') {
                    $activation = Activation::create($user);
                    $activation = Activation::complete($user, $activation->code);
                }
            }
            session()->flash('message', 'Success! Users are Activated successfully.');
            session()->flash('status', 'success');
            return response()->json(['success' => true, 'status' => 'Sucesfully Activated']);
        }
    }


}
