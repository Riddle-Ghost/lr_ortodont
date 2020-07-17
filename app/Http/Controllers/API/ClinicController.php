<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use App\Models\User;
use App\Services\ClinicService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;

class ClinicController extends Controller
{
    public $service;
    /**
     * ClinicController constructor.
     */
    public function __construct(ClinicService $service)
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->service = $service;
    }

    /**
     * Get all clinics.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (!Gate::check('admin-permission', Auth::user())) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        $clinics = User::query()
            ->where('role_id', '=', Role::CLINIC_ID)
            ->withCount('ordersForClinic as clients_count');

        return response()->json([
            'status' => 'Ok',
            'data' => $clinics->paginate(5)
        ], 200);
    }

    /**
     * Get clinic.
     *
     * @param User $clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $clinic)
    {
        if (!Gate::check('see-clinic', [ Auth::user(), $clinic ])) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        if ($clinic->role_id !== Role::CLINIC_ID) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Not found.'
            ], 404);
        }

        $clinic->load('clinicInfo');

        return response()->json([
            'status' => 'Ok',
            'data' => $clinic
        ], 200);
    }

    /**
     * Register clinic.
     *
     * @param StoreClinicRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClinicRequest $request)
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
     * Update clinic data.
     *
     * @param User $clinic
     * @param UpdateClinicRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $clinic, UpdateClinicRequest $request)
    {
        if (!Gate::check('admin-permission', Auth::user())) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        if ($clinic->role_id !== Role::CLINIC_ID) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Not found.'
            ], 404);
        }

        $this->service->update($clinic, $request);

        return response()->json([
            'status' => 'Ok'
        ], 200);
    }

    /**
     * Get attached doctors to clinic
     *
     * @param User $clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDoctors(User $clinic)
    {
        if (!Gate::check('admin-permission', Auth::user())) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        if ($clinic->role_id !== Role::CLINIC_ID) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'Ok',
            'data' => $clinic->doctors()->with([ 'doctorInfo' ])->get()
        ], 200);
    }
}