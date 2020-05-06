<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;

class CabinetController extends Controller
{
    /**
     * CabinetController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('access.clinic');
    }

    /**
     * Index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('cabinet.index');
    }
}
