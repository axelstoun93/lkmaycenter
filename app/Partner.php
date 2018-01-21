<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partners_info';
    protected $fillable = [
        'user_id','company_name','logo','address','phone','site','company_info','days_left','status'
    ];

}
