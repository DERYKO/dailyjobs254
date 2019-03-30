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

$factory->define(App\Job::class, function (Faker $faker) {
    return [
        'title'=>$faker->text(15),
        'owner_id'=>$faker->numberBetween(1,2),
        'description'=>$faker->text(100),
        'rules'=>$faker->text(100),
        'start_time'=>$faker->dateTime,
        'duration'=>$faker->numberBetween(0,90),
        'pay_amount'=>$faker->randomFloat(2,500,1000000),
        'job_location_address'=>$faker->address,
        'latitude'=>$faker->randomFloat(4,-1.0,4.0),
        'longitude'=>$faker->randomFloat(4,30.0,40.0),
    ];
});