<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

    public function __construct()
    {
        //
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('welcome');
    }
}
