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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\thread::class, function ($faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function() {
          return factory('App\Channel')->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->sentence,
    ];
});

$factory->define(App\Channel::class, function ($faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => $name
    ];

});

$factory->define(App\Reply::class, function ($faker) {
    return [
        'thread_id' => function () {
            return factory('App\thread')->create()->id;
        },
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'body' => $faker->sentence,
    ];

});

$factory->define(App\Notification::class, function ($faker) {
    return [
        'message' => $faker->sentence,
        'mustBeLoggedIn' =>$faker->boolean
    ];
});
