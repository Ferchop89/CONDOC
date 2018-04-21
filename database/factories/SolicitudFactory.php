<?php

use Faker\Generator as Faker;
use App\Models\Solicitud;
use App\Models\User;

$factory->define(Solicitud::class, function (Faker $faker) {
    return [
        'cuenta' =>  int_random(9),
        'user_id' => rand(1,User::all()->count()),
    ];
});
