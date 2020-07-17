<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\ClinicInfo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Dotenv\Exception\InvalidFileException;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;


class ClinicService
{

    public function store($request)
    {
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
    }
    
    public function update($clinic, $request)
    {
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
    }
}