<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Role::class, function (Faker $faker) {

    return [
        'name' => $faker->realText($maxNbChars = 5),
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