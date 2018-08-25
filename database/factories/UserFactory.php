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

$factory->define(App\Priority::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => function(){
        	return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->define(App\Subcategory::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => function(){
        	return factory(App\User::class)->create()->id;
        },
        'priority_id' => function(){
        	return factory(App\Priority::class)->create()->id;
        },
    ];
});

$factory->define(App\Act::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => function(){
        	return factory(App\User::class)->create()->id;
        },
        'subcategory_id' => function(){
        	return factory(App\Subcategory::class)->create()->id;
        },
    ];
});
