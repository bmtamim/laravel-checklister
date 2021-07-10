<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'package_id',
        'package_name',
        'package_type',
        'package_price',
        'package_start',
        'package_end',
        'stripe_id',
    ];

    protected $dates = [
        'package_start',
        'package_end',
    ];

}
