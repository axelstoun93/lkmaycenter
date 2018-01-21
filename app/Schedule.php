<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $fillable = [
        'id','title','place','note','schedule_css','place','category_id','date','start_time','end_time'
    ];
    public $timestamps = false;
    public function category()
    {
        return $this->belongsTo('App\CourseCategory');
    }
}
