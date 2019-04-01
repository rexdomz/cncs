<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //
    protected $dates = [
        'date_pay' => 'date:Y-m-d h:i:s',        
        'created_at',
        'updated_at'
    ];
}
