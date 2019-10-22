<?php

namespace App\Http\Middleware;

use Sentinel;
use Closure;

class AccessGrant
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
            $access = Sentinel::getUser()->access_grant;

            if ($access == true) {
                return $next($request);
            }
            //    $this->access_token['token'] =   Sentinel::getUser()->createToken('Barer')->accessToken;

            return route('login');



    }
}
