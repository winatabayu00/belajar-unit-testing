<?php

use App\Models\User;

use function Pest\Faker\faker;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;
use Illuminate\Support\Str;

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

it('can create user data (user is manager)', function (User $manager) {
    actingAs($manager)
        ->postJson(route('api.users.store'), [
            'name' => faker()->name . ' Bayu',
            'email' => faker()->email(),
            'password' => Str::random(10),
        ])->assertOk();
})->with('user_manager');

it('can\'t create user data (user not manager)', function (User $user, User $employee) {
    actingAs($user)
        ->postJson(route('api.users.store'), [
            'name' => faker()->name . ' Bayu',
            'email' => faker()->email(),
            'password' => Str::random(10),
        ])->assertForbidden();
    actingAs($employee)
        ->postJson(route('api.users.store'), [
            'name' => faker()->name . ' Bayu',
            'email' => faker()->email(),
            'password' => Str::random(10),
        ])->assertForbidden();
})->with('user', 'user_employee');
