<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\DoctorInfo;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Dotenv\Exception\InvalidFileException;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;



class DoctorService
{
    public function index($request)
    {
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

        return $doctors;
    }

    public function store($request)
    {
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
    }
    
    public function update($doctor, $request)
    {
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
    }

    public function getClinics($doctor, $request)
    {
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

        return $query;
    }
}