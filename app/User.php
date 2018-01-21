<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id', 'name','fio', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function roles() {
        return $this->belongsToMany('App\Role','role_user');
    }
    public function getPartnerInfo()
    {
        return $this->hasOne('App\Partner');
    }
    public function jobs()
    {
        return $this->hasOne('App\Job');
    }
   static public function getRole($id)
    {
        if(empty($id))
        {
          $string =  User::find($id)->roles()->first()->name;
          return $string;
        }
        else
        {
            return false;
        }

    }


    
}
