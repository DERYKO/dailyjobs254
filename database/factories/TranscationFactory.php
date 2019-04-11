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

$factory->define(App\Transcation::class, function (Faker $faker) {
    return [
        'from_id'=>$faker->randomElement([1,2]),
        'to_id'=>$faker->randomElement([2,1]),
        'transfer_type'=>$faker->randomElement(['b2c','c2b','b2b']),
        'amount'=>$faker->randomFloat(6,500,4000)
    ];
});