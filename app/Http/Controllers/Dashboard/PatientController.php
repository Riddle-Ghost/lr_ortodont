<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    /**
     * PatientController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('access.admin');
    }

    /**
     * Add patient page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('dashboard.patients.add');
    }

    /**
     * Patient's profile page.
     *
     * @param int $patientId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(int $patientId)
    {
        return view('dashboard.patients.profile', [
            'patientId' => $patientId
        ]);
    }

    /**
     * Edit patient page.
     *
     * @param int $patientId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $patientId)
    {
        return view('dashboard.patients.edit', [
            'patientId' => $patientId
        ]);
    }
}