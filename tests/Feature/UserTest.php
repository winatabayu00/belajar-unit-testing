<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

it('can\'t access user data (unauthorized)', function () {
    getJson(route('api.users.index'))
        ->assertUnauthorized();
});

it('can\'t access user data (user not manager)', function (User $user, User $employee) {
    actingAs($user)
        ->getJson(route('api.users.index'))
        ->assertForbidden();

    actingAs($employee)
        ->getJson(route('api.users.index'))
        ->assertForbidden();
})->with('user', 'user_employee');

it('can access user data (user is manager)', function (User $manager) {
    actingAs($manager)
        ->getJson(route('api.users.index'))
        ->assertOk();
})->with('user_manager');
