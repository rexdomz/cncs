<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Profiles;
use App\Payments;
use App\Http\Resources\Profiles as ProfilesResource;
use App\Http\Resources\Payments as PaymentsResource;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get profiles
        $payments = Payments::paginate(25);
        
        // Return collection of articles as a resource        
        return PaymentsResource::collection($payments);     
    }

    public function get_payments_by_user($id, $perpage)
    {
        // Get payments history
        $payments = Payments::where('profile_id', $id)->orderBy('date_pay', 'desc')->paginate($perpage);                

        // Return paginated records by area
        return PaymentsResource::collection($payments);        
    }

    public function store(Request $request)
    {
        try {
            $payment = $request->isMethod('put') ? Payments::findOrFail($request->pay_id) : new Payments;            
            $payment->id = $request->input('pay_id');
            $payment->profile_id = $request->input('profile_id');
            $payment->pay = $request->input('pay');            
            $payment->date_pay = $request->input('date_pay');                  

            if($payment->save()) {
                return new PaymentsResource($payment);
            }
            
        } catch (ModelNotFoundException $ex) {
        } catch (Exception $ex) {
            abort(500, 'Could not create office or assign it to administrator');
        }

    }

    public function destroy($id)
    {
        // Get profile
        $payment = Payments::findOrFail($id);

        if($payment->delete()) {
            return new PaymentsResource($payment);
        }                  
    }
   
}
