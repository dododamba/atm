<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Route;
use Request;
use Session;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $api = "")
    {
        $routeName = $request->route()->getName();
        if (empty($routeName) || Sentinel::hasAccess($routeName)) {
            return $next($request);
        }

        if (!empty($api)) {
            return response()->json(['message' => 'you_dont_have_permission_to_use_this_route'], 403);
        } else {

            alert()->html('<h3><i class="fa fa-warning text-danger"></i> </h3>', "
                  <u><h4>Erreur Permission</h4></u>,
                  <p class='text-danger'>Vous n'avez pas la permission necessaire pour acceder a cette resource</p>
                ");

            return redirect()->back();
        }


    }
}