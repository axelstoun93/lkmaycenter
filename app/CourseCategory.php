<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    protected $table = 'course_category';
    protected $fillable = [
        'id','title'
    ];
    public function course() {
        return $this->hasMany('App\Course');
    }
}
