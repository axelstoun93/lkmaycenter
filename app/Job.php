<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'partners_job';
    protected $fillable = [
       'user_id','post_id','job_title','job_category','duties','demand','work_experience','condition','salary','working_schedule','address','updated_at','created_at'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function info()
    {
        return $this->hasOne('App\Partner','user_id','user_id');
    }
}
