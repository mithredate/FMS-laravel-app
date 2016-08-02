<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Mithredate\FMSUpdater\Model\FMSUpdater;

$factory->define(FMSUpdater::class, function (Faker\Generator $faker) {
    return [
        'hash' => sha1(str_random(16))
    ];
});
