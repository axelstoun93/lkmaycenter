<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients_info';
    protected $fillable = [
        'user_id','company_name','logo','address','phone','company_info','days_left','status'
    ];
}
