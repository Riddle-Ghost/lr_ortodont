<?php

namespace App\Http\Controllers\API;

use App\DoctorInfo;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddClinitToDoctorRequest;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\OrderStatus;
use App\Role;
use App\User;
use Barryvdh\Debugbar\LaravelDebugbar;
use Dotenv\Exception\InvalidFileException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;

class DoctorController extends Controller
{
    /**
     * DoctorController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
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

        $doctors = User::query()
            ->where('role_id', '=', Role::DOCTOR_ID)
            ->with([ 'doctorInfo' ])
            ->withCount([
                'ordersForDoctor as orders_all_count',
                'ordersForDoctor as orders_waiting_count' => function (Builder $query) {
                    $query->where('order_status_id', '=', OrderStatus::WAITING);
                },
                'ordersForDoctor as orders_modeling_count' => function (Builder $query) {
                    $query->where('order_status_id', '=', OrderStatus::MODELING);
                },
                'ordersForDoctor as orders_cure_count' => function (Builder $query) {
                    $query->where('order_status_id', '=', OrderStatus::CURE);
                },
                'ordersForDoctor as orders_done_count' => function (Builder $query) {
                    $query->where('order_status_id', '=', OrderStatus::DONE);
                },
            ]);

        if ($request->query('search', null) !== null) {
            $search = $request->query('search');

            $doctors->where(function (Builder $query) use ($search) {
                $query
                    ->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->query('all', 0) !== 0) {
            $doctors = $doctors->get();
        } else {
            $doctors = $doctors->paginate(5);
        }

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

        DB::transaction(function () use ($request) {
            $doctor = new User();
            $tempPassword = Str::random(16);

            $doctor->email = $request->get('email');
            $doctor->name = $request->get('name');
            $doctor->password = Hash::make($tempPassword);
            $doctor->phone = $request->get('phone');
            $doctor->role_id = Role::DOCTOR_ID;

            $doctor->save();

            $doctorInfo = new DoctorInfo();

            $doctorInfo->position = $request->get('position');
            $doctorInfo->birthday = date('Y-m-d', strtotime($request->get('birthday')));
            $doctorInfo->description = $request->get('description');
            $doctorInfo->user_id = $doctor->id;

            if ($request->file('photo', null) !== null) {
                if ($request->file('photo')->isValid()) {
                    $photoPath = $request->file('photo')->storePubliclyAs(
                        'public/images',
                        (string)Str::uuid() . '.' . $request->file('photo')->extension()
                    );

                    if ($photoPath === false) {
                        throw new CannotWriteFileException('Couldn\'t upload photo.');
                    }

                    $doctorInfo->photo = $photoPath;
                } else {
                    throw new InvalidFileException('Photo isn\'t valid.');
                }
            }

            $doctorInfo->save();

            $doctor->sendEmailVerificationNotification($tempPassword);
        });

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

        DB::transaction(function () use ($doctor, $request) {
            if ($request->file('photo', null) !== null) {
                if ($request->file('photo')->isValid()) {
                    $photoPath = $request->file('photo')->storePubliclyAs(
                        'public/images',
                        (string)Str::uuid() . '.' . $request->file('photo')->extension()
                    );

                    if ($photoPath === false) {
                        throw new CannotWriteFileException('Could\'t upload photo.');
                    }

                    $doctor->doctorInfo->update([
                        'photo' => $photoPath
                    ]);
                } else {
                    throw new InvalidFileException('Photo isn\'t valid.');
                }
            }

            if ($request->get('position', null) !== null) {
                $doctor->doctorInfo->update([
                    'position' => $request->get('position')
                ]);
            }

            if ($request->get('birthday', null) !== null) {
                $doctor->doctorInfo->update([
                    'birthday' => date('Y-m-d', strtotime($request->get('birthday')))
                ]);
            }

            if ($request->get('description', null) !== null) {
                $doctor->doctorInfo->update([
                    'description' => $request->get('description')
                ]);
            }

            $doctor->update(array_filter($request->except([ 'photo', 'position', 'birthday', 'description' ])));

            if ($doctor->isDirty('email')) {
                $doctor->sendEmailVerificationNotification();
            }
        });

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

        $query = $doctor
            ->clinics()
            ->withCount([
                'ordersForClinic as doctors_all_patients' => function (Builder $query) use ($doctor) {
                    $query->where('doctor_id', '=', $doctor->id);
                },
                'ordersForClinic as doctors_waiting_patients' => function (Builder $query) use ($doctor) {
                    $query
                        ->where('doctor_id', '=', $doctor->id)
                        ->where('order_status_id', '=', OrderStatus::WAITING);
                },
                'ordersForClinic as doctors_modeling_patients' => function (Builder $query) use ($doctor) {
                    $query
                        ->where('doctor_id', '=', $doctor->id)
                        ->where('order_status_id', '=', OrderStatus::MODELING);
                },
                'ordersForClinic as doctors_cure_patients' => function (Builder $query) use ($doctor) {
                    $query
                        ->where('doctor_id', '=', $doctor->id)
                        ->where('order_status_id', '=', OrderStatus::CURE);
                },
                'ordersForClinic as doctors_done_patients' => function (Builder $query) use ($doctor) {
                    $query
                        ->where('doctor_id', '=', $doctor->id)
                        ->where('order_status_id', '=', OrderStatus::DONE);
                },
            ]);

        if ($request->query('search', null) !== null) {
            $search = $request->query('search');

            $query->where(function (Builder $query) use ($search) {
                $query
                    ->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        return response()->json([
            'status' => 'Ok',
            'data' => $query->paginate(5),
        ], 200);
    }
}