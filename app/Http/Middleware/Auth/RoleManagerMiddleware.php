<?php

namespace App\Http\Middleware\Auth;

use Closure;
use App\Http\Controllers\Auth\RouteLogicController as RouteLogicController;

class RoleManagerMiddleware
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
        if($request->session()->has('manager'))
        {
            return $next($request);
        }
        else
        {
            return redirect(RouteLogicController::redirectLogic());
        }
    }
}
