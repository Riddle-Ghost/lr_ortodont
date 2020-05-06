<?php

namespace App\Http\Controllers\API;

use App\ClinicInfo;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;
use App\Role;
use App\User;
use Dotenv\Exception\InvalidFileException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;

class ClinicController extends Controller
{
    /**
     * ClinicController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
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

        DB::transaction(function () use ($request) {
            $clinic = new User();
            $tempPassword = Str::random(16);

            $clinic->name = $request->get('name');
            $clinic->email = $request->get('email');
            $clinic->password = Hash::make($tempPassword);
            $clinic->phone = $request->get('phone');
            $clinic->role_id = Role::CLINIC_ID;

            $clinic->save();

            $clinicInfo = new ClinicInfo();

            $clinicInfo->user_id = $clinic->id;
            $clinicInfo->legal_name = $request->get('legal_name');
            $clinicInfo->address = $request->get('address');
            $clinicInfo->legal_address = $request->get('legal_address');
            $clinicInfo->requisites = $request->get('requisites');

            if ($request->file('photo', null) !== null) {
                if ($request->file('photo')->isValid()) {
                    $photoPath = $request->file('photo')->storePubliclyAs(
                        'public/images',
                        (string)Str::uuid() . '.' . $request->file('photo')->extension()
                    );

                    if ($photoPath === false) {
                        throw new CannotWriteFileException('Couldn\'t upload photo.');
                    }

                    $clinicInfo->photo = $photoPath;
                } else {
                    throw new InvalidFileException('Photo isn\'t valid.');
                }
            }

            $clinicInfo->save();

            $clinic->sendEmailVerificationNotification($tempPassword);
        });

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

        DB::transaction(function () use ($clinic, $request) {
            $clinic->update(array_filter($request->except([
                'legal_name',
                'address',
                'legal_address',
                'requisites',
                'photo'
            ])));

            $clinic->clinicInfo()->update(array_filter($request->except([
                'name',
                'email',
                'phone',
                'photo'
            ])));

            if ($request->file('photo', null) !== null) {
                if ($request->file('photo')->isValid()) {
                    $photoPath = $request->file('photo')->storePubliclyAs(
                        'public/images',
                        (string)Str::uuid() . '.' . $request->file('photo')->extension()
                    );

                    if ($photoPath === false) {
                        throw new CannotWriteFileException('Couldn\'t upload photo.');
                    }

                    $clinic->clinicInfo()->update([
                        'photo' => $photoPath
                    ]);
                } else {
                    throw new InvalidFileException('Photo isn\'t valid.');
                }
            }

            if ($clinic->isDirty('email')) {
                $clinic->sendEmailVerificationNotification();
            }
        });

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