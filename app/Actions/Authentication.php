<?php

namespace App\Actions;

class Authentication
{
    public function handle($request): bool
    {
        if (!auth()->attempt($request->only(['email', 'password']))) {
            return false;
        }
        return true;
    }
}
