<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(User::class, function (Faker $faker) {

    $active = $faker->boolean();

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'email_verified_at' => $active ? now() : null,
        'role_id' => Role::DOCTOR_ID,
        'remember_token' => Str::random(10),
    ];
});

        // 'status' => $active ? User::STATUS_ACTIVE : User::STATUS_WAIT,
        
        // 'verify_token' => $active ? null : Str::uuid(),

$factory->state(User::class, 'admin', [
    'name' => 'admin',
    'email' => 'admin@admin.admin',
    // 'status' => User::STATUS_ACTIVE,
    'role_id' => Role::ADMIN_ID,
    'email_verified_at' => now(),
    // 'verify_token' => null,
]);