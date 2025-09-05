<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CoursePrice;

class Plan extends Model
{
    //
    protected $table = 'plans';

    protected $fillable = [
        'course_id',
        'user_id',
        'referred_by',
        'valid',
        'amount',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   public function course()
   {
    return $this->belongsTo(Course::class, 'course_id');
   }
   

public function getCoursePriceAttribute()
{
    return CoursePrice::where('course_id', $this->course_id)
                      ->where('duration', $this->valid)
                      ->first();
}





}
