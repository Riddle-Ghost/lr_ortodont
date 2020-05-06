<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexOrderRequest;
use App\Http\Requests\StoreClinicRequest;
use App\Order;
use App\OrderStatus;
use App\Patient;
use App\Payment;
use App\User;
use Dotenv\Exception\InvalidFileException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;

class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
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
        DB::transaction(function () use ($request) {
            $order = new Order();

            if (
                !Gate::check(
                    'set-clinic-order',
                    [ Auth::user(), User::find($request->get('clinic_id')) ]
                )
            ) {
                throw new UnauthorizedException();
            }

            $order->clinic_id = $request->get('clinic_id');
            $order->order_status_id = OrderStatus::WAITING;

            $payment = new Payment();
            $payment->method = $request->get('payment_method');
            $payment->option = $request->get('payment_option');
            $payment->save();

            $patient = new Patient();

            $patient->name = $request->get('patient_name');
            $patient->surname = $request->get('patient_surname');
            $patient->patronymic = $request->get('patient_patronymic');
            $patient->sex = $request->get('patient_sex');
            $patient->birthday = $request->get('patient_birthday');
            $patient->diagnosis = $request->get('patient_diagnosis');

            $patientPhotosKeys = [
                'profile',
                'fullface_smile',
                'fullface_without_smile',
                'occlusar_up',
                'occlusar_down',
                'lateral_left',
                'front',
                'lateral_right',
            ];

            foreach ($patientPhotosKeys as $key) {
                if ($request->file('patient_photo_' . $key)->isValid()) {
                    $path = $request->file('patient_photo_' . $key)->storePublicly(
                        'images',
                        (string)Str::uuid() . $request->file('patient_photo_' . $key)->extension()
                    );

                    if ($path === false) {
                        throw new CannotWriteFileException();
                    }

                    $patient->{'photo_' . $key} = $path;
                } else {
                    throw new InvalidFileException();
                }
            }

            $patient->save();

            $order->payment_id = $payment->id;
            $order->patient_id = $patient->id;
            $order->recipe = $request->get('recipe');

            $order->save();
        });

        return response()->json([
            'status' => 'Ok'
        ], 200);
    }
}