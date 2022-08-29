<?php

use App\Models\User;

dataset('user', function () {
    yield fn () => User::factory()->create();
});

dataset('user_manager', function () {
    yield fn () => User::factory()->create()->assignRole('Manager');
});

dataset('user_employee', function () {
    yield fn () => User::factory()->create()->assignRole('Employee');
});
