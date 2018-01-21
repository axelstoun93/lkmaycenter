<?php

namespace App\Http\Middleware\Auth;

use Closure;
use App\Http\Controllers\Auth\RouteLogicController as RouteLogicController;

class RoleClientMiddleware
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
        if($request->session()->has('client'))
        {
            return $next($request);
        }
        else
        {
            return redirect(RouteLogicController::redirectLogic());
        }
    }
}
