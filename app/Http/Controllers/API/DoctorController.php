<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use App\Models\User;

use Illuminate\Http\Request;
use App\Services\DoctorService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Requests\AddClinitToDoctorRequest;

class DoctorController extends Controller
{
    public $service;
    /**
     * DoctorController constructor.
     */
    public function __construct(DoctorService $service)
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->service = $service;
    }

    /**
     * Get all doctors.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (!Gate::check('admin-permission', Auth::user())) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        $doctors = $this->service->index($request);

        return response()->json([
            'status' => 'Ok',
            'data' => $doctors
        ], 200);
    }

    /**
     * Get doctor.
     *
     * @param User $doctor
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $doctor)
    {
        if (!Gate::check('edit-doctor', [ Auth::user(), $doctor ])) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        if ($doctor->role_id !== Role::DOCTOR_ID) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Not found.'
            ], 404);
        }

        $doctor->load('doctorInfo');

        return response()->json([
            'status' => 'Ok',
            'data' => $doctor
        ], 200);
    }

    /**
     * Register doctor.
     *
     * @param StoreDoctorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDoctorRequest $request)
    {
        if (!Gate::check('admin-permission', Auth::user())) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        $this->service->store($request);

        return response()->json([
            'status' => 'Ok'
        ], 200);
    }

    /**
     * Update doctor data.
     *
     * @param User $doctor
     * @param UpdateDoctorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDoctorRequest $request, User $doctor)
    {
        if (!Gate::check('edit-doctor', [ Auth::user(), $doctor ])) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        if ($doctor->role_id !== Role::DOCTOR_ID) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Doctor not found.'
            ], 404);
        }

        $this->service->update($doctor, $request);

        return response()->json([
            'status' => 'Ok'
        ], 200);
    }

    /**
     * Attach clinic to doctor.
     *
     * @param User $doctor
     * @param AddClinitToDoctorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addClinic(User $doctor, AddClinitToDoctorRequest $request)
    {
        if (!Gate::check('admin-permission', Auth::user())) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        if ($doctor->role_id !== Role::DOCTOR_ID) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Doctor not found.'
            ], 404);
        }

        if ($doctor->clinics()->find($request->get('clinic_id'))->count() === 1) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Doctor is already fixed to this clinic.'
            ], 409);
        }

        $doctor->clinics()->attach($request->get('clinic_id'));

        return response()->json([
            'status' => 'Ok',
        ], 200);
    }

    /**
     * Detach clinic from doctor.
     *
     * @param User $doctor
     * @param User $clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeClinic(User $doctor, User $clinic)
    {
        if (!Gate::check('admin-permission', Auth::user())) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        if ($doctor->role_id !== Role::DOCTOR_ID) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Doctor not found.'
            ], 404);
        }

        if ($doctor->clinics()->find($clinic->id)->count() !== 1) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Doctor isn\'t fixed to this clinic.'
            ], 400);
        }

        $doctor->clinics()->detach($clinic->id);

        return response()->json([
            'status' => 'Ok',
        ], 200);
    }

    /**
     * Get doctor's clinics.
     *
     * @param User $doctor
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClinics(User $doctor, Request $request)
    {
        if (!Gate::check('admin-permission', Auth::user())) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        if ($doctor->role_id !== Role::DOCTOR_ID) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Doctor not found.'
            ], 404);
        }

        $query = $this->service->getClinics($doctor, $request);

        return response()->json([
            'status' => 'Ok',
            'data' => $query->paginate(5),
        ], 200);
    }
}