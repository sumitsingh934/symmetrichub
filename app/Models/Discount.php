<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
        protected $table = 'discounts';

    protected $fillable = [
        'title',
        'discount_duration_day',
        'discount_date',
        'coupon_number',
        'percentage',
        'description',
        'status',
    ];

}
