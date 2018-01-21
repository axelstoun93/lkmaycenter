<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $fillable = [
        'id','title','course_note','course_css','category_id','date','start_time','end_time'
    ];
    public $timestamps = false;
    public function category()
    {
        return $this->belongsTo('App\CourseCategory');
    }
}
