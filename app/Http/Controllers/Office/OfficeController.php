<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;

class OfficeController extends Controller
{
    /**
     * OfficeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('access.doctor');
    }

    /**
     * Index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('office.index');
    }

    /**
     * Clinic page.
     *
     * @param int $clinicId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function clinic(int $clinicId)
    {
        return view('office.clinic', [
            'clinicId' => $clinicId
        ]);
    }
}