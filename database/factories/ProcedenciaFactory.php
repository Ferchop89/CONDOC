<?php

use Faker\Generator as Faker;
use App\Models\Procedencia;

$factory->define(Procedencia::class, function (Faker $faker) {
    return [
      'procedencia' => $faker->sentence(),
    ];
});
