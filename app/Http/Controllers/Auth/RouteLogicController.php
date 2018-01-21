<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RouteLogicController extends Controller
{

    static function redirectLogic()
    {
            $name = User::find(Auth::user()->id)->roles()->first()->id;
            switch ($name)
            {
                case '1':
                    if(Session::has('administrator'))
                    {
                        return '/administrator';
                    }
                    else
                    {
                        Session::put('administrator', '1');
                        return '/administrator';
                    }
                    break;
                case '2':
                    if(Session::has('manager'))
                    {
                        return '/manager';
                    }
                    else
                    {
                        Session::put('manager', '1');
                        return '/manager';
                    }
                    break;
                case '3':
                    if(Session::has('partner'))
                    {
                        return '/partner';
                    }
                    else
                    {
                        Session::put('partner', '1');
                        return '/partner';
                    }
                    break;
                default:
                    Auth::logout();
                    return '/';
                    break;
            }
    }
}
