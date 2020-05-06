<?php

namespace App\Http\Controllers\Office;

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
        $this->middleware('access.doctor');
    }

    /**
     * Add patient page.
     *
     * @param int $clinicId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(int $clinicId)
    {
        return view('office.patients.add', [
            'clinicId' => $clinicId
        ]);
    }

    /**
     * Patient's profile page.
     *
     * @param int $clinicId
     * @param int $patientId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(int $clinicId, int $patientId)
    {
        return view('office.patients.profile', [
            'clinicId' => $clinicId,
            'patientId' => $patientId
        ]);
    }
}
