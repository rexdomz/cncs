<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Profiles;
use App\Http\Resources\Profiles as ProfilesResource;
use Carbon\Carbon;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get profiles
        $profiles = Profiles::orderBy('full_name', 'asc')->paginate(25);
        
        // Return collection of articles as a resource               
        return ProfilesResource::collection($profiles);        
        
    }


    public function get_profiles_by_area($id, $perpage)
    {
        // Get profiles        
        $profiles = Profiles::where('area', $id)->orderBy('full_name', 'asc')->paginate($perpage);                

        // Return paginated records by area
        return ProfilesResource::collection($profiles);        
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profile = $request->isMethod('put') ? Profiles::findOrFail($request->profile_id) : new Profiles;

        $profile->id = $request->input('profile_id');
        $profile->full_name = $request->input('full_name');
        $profile->address = $request->input('address');
        $profile->area = $request->input('area');
        $profile->loan = $request->input('loan');
        $profile->interest = $request->input('interest');
        $profile->term = $request->input('term');
        
        //$profile->date_from = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('date_from') );
        //$profile->date_from = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('date_to') );
        $profile->date_from = date('Y-m-d', strtotime($request->input('date_from')));
        $profile->date_from = date('Y-m-d', strtotime($request->input('date_to')));
        //this.profile.date_from = '2019-01-04 00:00:00'
        //'2019-01-29 00:00:00' toDateTimeString
        //$profile->date_from = $request->input('date_from');      
        //$profile->date_to = $request->input('date_to');

        $profile->contact = $request->input('contact');

        if($profile->save()) {
            return new ProfileResource($profile);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get article
        $profile = Profiles::findOrFail($id);

        // Return single article as a resource
        return new ProfilesResource($profile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get profile
        $profile = Profiles::findOrFail($id);

        if($profile->delete()) {
            return new ProfilesResource($profile);
        }                  
    }
}
