<?php

use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Question;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'question_id' => function() {
            return Question::all()->random()->id;
        },
        'user_id' => function() {
            return User::all()->random();
        },
    ];
});
