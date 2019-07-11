<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    protected $appends = ['totalpay', 'amountloan'];

    function getTotalPayAttribute() {                            
        $payments = DB::table('payments')->where('profile_id', $this->id)->orderBy('date_pay', 'desc')->get();              
        $totalPayment = 0;        
        foreach($payments as $item) {
            $totalPayment += $item->pay;
        }                    
        return $totalPayment;        
      }
    
      function getAmountLoanAttribute() {                        
        $loanAmount = $this->loan + ($this->loan * $this->interest/100 * $this->term);
        return $loanAmount; 
      }

}
