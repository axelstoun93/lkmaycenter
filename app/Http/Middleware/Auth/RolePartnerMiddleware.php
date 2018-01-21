<?php

namespace App\Http\Middleware\Auth;

use Closure;
use App\Http\Controllers\Auth\RouteLogicController as RouteLogicController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
class RolePartnerMiddleware
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

        if($request->session()->has('partner'))
        {
            if(!empty(Session::has('access')))
            {
                return $next($request);
            }
            else
            {
                return $this->limitedAccess($request,$next);
            }
        }
        else
        {
            return redirect(RouteLogicController::redirectLogic());
        }
    }
    public function limitedAccess($request,Closure $next)
    {

      $id = Auth::id();
      $user = new UserRepository(new User());
      $array = $user->getOnePartner($id,true);
      if($array->countInfo < 5)
      {
          if(empty(Session::has('l-access')))
          {
              $alert = ['href'=> route('profile'),'image' => 'fa fa-lock bg-warning','title' => 'Функционал ограничен!' ,'message' => "Пожалуйста заполните свой профиль"];
              Session::put('l-access', $alert);
          }
          if(Route::currentRouteName() == 'jobs' or Route::currentRouteName() == 'examinations')
          {
              return redirect(route('home'));
          }
      }else
      {
          Session::forget('l-access');
          Session::put('access', true);
      }
        return $next($request);
    }
}
