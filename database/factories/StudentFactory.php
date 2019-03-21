<?php


$factory->define(App\Models\Student::class, function (Faker\Generator $faker) {
    return [
        "surname"     => $faker->lastname,
        "firstname"   => $faker->firstname,
        "nationality" => $faker->countryCode,
        "email"       => $faker->unique()->safeEmail,
        "address_id"  => 0,
        "course_id"   => 0,
    ];
});
