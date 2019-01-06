<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurants extends Model
{
    protected $fillable = [
        'rest_name',
        'rest_address',
        'tel_num',
        'lat',
        'lng'
    ];
}
