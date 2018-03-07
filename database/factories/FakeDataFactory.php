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

$factory->define(MinhD\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(MinhD\Role::class, function(Faker $faker){
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph
    ];
});

$factory->define(MinhD\Repository\DataSource::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->paragraph(),
        'user_id' => factory(MinhD\User::class)->create()->id
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

$factory->define(\MinhD\Repository\Record::class, function (Faker $faker){
    return [
        'title' => $faker->name,
        'status' => \MinhD\Repository\Record::STATUS_PUBLISHED,
        'data_source_id' => factory(MinhD\Repository\DataSource::class)->create()->id
    ];
});