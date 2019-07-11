<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin-dashboard');
    }

    public function register()
    {
        return view('registration');
    }

    public function registered_users()
    {
        return view('regusers');
    }

    public function payment()
    {
        return view('payment');
    }

    public function collector()
    {
        return view('collector');
    }

    public function area()
    {
        return view('areas');
    }

    public function release() {
        return view('release');
    }

}
