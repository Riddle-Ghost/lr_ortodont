<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    /**
     * DoctorController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('access.admin');
    }

    /**
     * Doctors page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.doctors.doctors');
    }

    /**
     * Add doctor page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('dashboard.doctors.add');
    }

    /**
     * Doctor's profile page.
     *
     * @param int $doctorId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(int $doctorId)
    {
        return view('dashboard.doctors.profile', [
            'doctorId' => $doctorId
        ]);
    }

    /**
     * Edit doctor page.
     *
     * @param int $doctorId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $doctorId)
    {
        return view('dashboard.doctors.edit', [
            'doctorId' => $doctorId
        ]);
    }
}