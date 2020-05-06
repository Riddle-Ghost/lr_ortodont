<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class ClinicController extends Controller
{
    /**
     * ClinicController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('access.admin');
    }

    /**
     * Add clinic page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('dashboard.clinics.add');
    }

    /**
     * Clinic's profile page.
     *
     * @param int $clinicId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(int $clinicId)
    {
        return view('dashboard.clinics.profile', [
            'clinicId' => $clinicId
        ]);
    }

    /**
     * Edit clinic page.
     *
     * @param int $clinicId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $clinicId)
    {
        return view('dashboard.clinics.edit', [
            'clinicId' => $clinicId
        ]);
    }
}