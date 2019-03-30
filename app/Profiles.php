<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    
    protected $fillable = [
        //'profiles'
    ];

    protected $dates = [
        'date_from' => 'date:Y-m-d h:i:s',
        'date_to' => 'date:Y-m-d h:i:s',
        'created_at',
        'updated_at'
    ];

}
