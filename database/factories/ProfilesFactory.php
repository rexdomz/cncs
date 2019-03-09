<?php

use Faker\Generator as Faker;

$factory->define(App\Profiles::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'address'  => $faker->address,
        'area'  => $faker->postcode,
        'loan'  => $faker->randomFloat($nbMaxDecimals = 2, $min = 5, $max = 10),
        'interest'  => $faker->randomDigit,
        'term'  => $faker->randomDigit,
        'date_from'  => $faker->dateTimeThisYear('+1 week'),
        'date_to'  => $faker->dateTimeThisYear('+1 month'),
        'contact'  => $faker->phoneNumber(15)        
    ];
});
