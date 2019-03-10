<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Area extends Resource
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
            'area_code' => $this->area_code,
            'address' => $this->address,
            'collector' => $this->collector,
            'contact' => $this->contact    
        ];    
    }
}
