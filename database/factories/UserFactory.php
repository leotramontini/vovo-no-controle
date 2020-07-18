<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Vovo\Models\User;
use Vovo\Models\Bank;
use \Vovo\Models\Bill;
use Vovo\Models\BankUser;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Bank::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});

$factory->define(BankUser::class, function (Faker $faker) {
    return [
        'balance'   => $faker->randomDigitNotNull
    ];
});

$factory->define(Bill::class, function (Faker $faker) {
    return [
        'description'   => $faker->word,
        'value'         => $faker->randomDigitNotNull,
        'date'          => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
