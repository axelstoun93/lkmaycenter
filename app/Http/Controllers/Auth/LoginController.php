<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Controllers\Auth\RouteLogicController as RouteLogicController;
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
    

    use AuthenticatesUsers;
 

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function redirectTo()
    {
        return  RouteLogicController::redirectLogic();
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function redirectLogic()
    {
        $name = User::find(Auth::user()->id)->roles()->first()->name;
        if(!empty($name)){
            switch ($name)
            {
                case 'Admin':
                    return '/admin';
                    break;
                case 'Manager':
                    return '/manager';
                    break;
                case 'Client':
                    return '/client';
                    break;
                default:
                    Auth::logout();
                    return '/';
                    break;
            }
        }
        else
        {
            Auth::logout();
            return '/';
        }
    }

}
