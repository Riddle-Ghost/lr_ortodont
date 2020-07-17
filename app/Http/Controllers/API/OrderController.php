<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexOrderRequest;
use App\Http\Requests\StoreClinicRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public $service;
    /**
     * OrderController constructor.
     */
    public function __construct(OrderService $service)
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->service = $service;
    }

    /**
     * Get orders.
     *
     * @param IndexOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexOrderRequest $request)
    {
        $filterClinicId = $request->get('clinic_id', false);
        $filterDoctorId = $request->get('doctor_id', false);

        if (
            $filterClinicId === false &&
            $filterDoctorId === false &&
            !Gate::check('admin-permission', [ Auth::user() ])
        ) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        $query = Order::query();

        if ($filterClinicId !== false) {
            $clinic = User::find($filterClinicId);

            if (!Gate::check('see-clinic', [ Auth::user(), $clinic ])) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Access denied.'
                ], 403);
            }

            $query = $query->where('clinic_id', '=', $clinic->id);
        }

        if ($filterDoctorId !== false) {
            $doctor = User::find($filterDoctorId);

            if (!Gate::check('edit-doctor', [ Auth::user(), $doctor ])) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Access denied.'
                ], 403);
            }

            $query = $query->where('doctor_id', '=', $doctor->id);
        }

        return response()->json([
            'status' => 'Ok',
            'data' => $query->paginate()
        ]);
    }

    /**
     * Get order.
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        if (!Gate::check('see-order', [ Auth::user(), $order ])) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Access denied.'
            ], 403);
        }

        $order->load('clinic');
        $order->load('doctor');
        $order->load('status');
        $order->load('payment');
        $order->load('patient');

        return response()->json([
            'status' => 'Ok',
            'data' => $order
        ]);
    }

    /**
     * Store order.
     *
     * @param StoreClinicRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClinicRequest $request)
    {
        $this->service->store($request);

        return response()->json([
            'status' => 'Ok'
        ], 200);
    }
}