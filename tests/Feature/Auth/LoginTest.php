<?php

use App\Models\User;
use function Pest\Laravel\postJson;
use function Pest\Faker\faker;

it('can\'t login (validation error)', function () {
    postJson(route('api.login'))
        ->assertUnprocessable();
});

it('can\'t login (invalid email or password combination)', function (User $user) {
    postJson(route('api.login'), [
        'email' => $user->email,
        'password' => faker()->password(8),
    ])->assertUnauthorized();
})->with('user');

it('can login', function (User $user) {
    postJson(route('api.login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertOk();
})->with('user');
