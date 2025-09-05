<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePrice extends Model
{
    //
    protected $table = 'courses_prices';

    protected $fillable = [
        'course_id',
        'price',
        'currency',
        'discount',
        'duration',
        'status',
    ];

public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}

 public function plan()
{
    return $this->hasMany(Plan::class, 'course_id');
}

}
