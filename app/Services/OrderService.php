<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Dotenv\Exception\InvalidFileException;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;



class OrderService
{

    public function store($request)
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
    }
}