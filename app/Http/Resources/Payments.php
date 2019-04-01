<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Payments extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'pay' => $this->pay,
            'date_pay' => $this->date_pay            
        ];
    }
}
