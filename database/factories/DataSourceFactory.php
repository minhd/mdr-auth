<?php

use Faker\Generator as Faker;
use MinhD\User;

$factory->define(MinhD\Repository\DataSource::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->paragraph(),
        'user_id' => factory(User::class)->create()->id
    ];
});

$factory->define(\MinhD\Repository\Schema::class, function(Faker $faker){
    $name = $faker->name;
    return [
        'title' => $faker->name,
        'description' => $faker->paragraph(),
        'url' => $faker->url,
        'shortcode' => str_slug($name)
    ];
});