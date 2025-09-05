<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'status',
    ];

 public function course_price()
{
    return $this->hasMany(CoursePrice::class, 'course_id');
}

public function details()
{
    return $this->hasMany(CoursePrice::class);
}


}
