<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Profiles extends Resource
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
            'full_name' => $this->full_name,
            'address' => $this->address,
            'area' => $this->area,
            'loan' => $this->loan,
            'interest' => $this->interest,
            'term' => $this->term,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'contact' => $this->contact,
            'totalpay' => $this->totalpay,
            'amount_loan' => $this->amountloan
            //'etc' => $this->etc            
        ];
    }
}
