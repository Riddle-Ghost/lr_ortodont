<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(Role::class, function (Faker $faker) {

    return [
        'name' => $faker->realText($maxNbChars = 10),
    ];
});

$factory->state(Role::class, 'admin', [
    'id' => Role::ADMIN_ID,
    'name' => 'admin',
]);

$factory->state(Role::class, 'doctor', [
    'id' => Role::DOCTOR_ID,
    'name' => 'doctor',
]);

$factory->state(Role::class, 'clinic', [
    'id' => Role::CLINIC_ID,
    'name' => 'clinic',
]);