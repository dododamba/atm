<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Actions;
use Sentinel;

class LogActions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ac = new Actions();
        if($user = Sentinel::getUser()){
            $ac->idUser = Sentinel::getUser()->id;
            $ac->libelleAction = $request->method()." ".$request->path();
            $ac->dateAction = date("Y-m-d H:i:s");
            $ac->level = 1;
            $ac->deviceInfo = "";

            $ac->save();
        }

        return $next($request);
    }
}
