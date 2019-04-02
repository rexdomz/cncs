<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Area;
use App\Http\Resources\Area as AreaResource;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get profiles
        $areas = Area::paginate(20);
        
        // Return collection of articles as a resource        
        return AreaResource::collection($areas);    
    }

    public function show($id)
    {
        // Get article
        $area = Area::findOrFail($id);

        // Return single article as a resource
        return new AreaResource($area);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $area = $request->isMethod('put') ? Area::findOrFail($request->area_id) : new Area;

        $area->id = $request->input('area_id');
        $area->area_code = $request->input('area_code');        
        $area->address = $request->input('address');        
        $area->collector = $request->input('collector');        
        $area->contact = $request->input('contact');        

        if($area->save()) {
            return new AreaResource($area);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
