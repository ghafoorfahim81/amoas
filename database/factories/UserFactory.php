<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Booking::class, function (Faker $faker) {
    return [
        'department_id' => 96,
        'serial_no' => 'CBONN-1234421-2134',
        'user_id' => 1565,
        'package_id' => $faker->randomElement([1, 2, 3]),
        'booking_date' => $faker->dateTimeBetween('2019-11-02', '2019-11-30'),
        'booking_time' => $faker->randomElement(['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM']),
        'google_calendar_event_id' => 1,
        'status' => 'On Process',
    ];
});

$factory->define(App\Models\Booking\BookingInfo::class, function (Faker $faker) {
    return [
        'booking_id' => null,
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'id_card' => 'fds-43-fd-34',
        'postal' => $faker->postcode,
        'address' => $faker->address,
    ];
});
