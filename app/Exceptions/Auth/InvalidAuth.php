<?php

namespace App\Exceptions\Auth;

use Illuminate\Auth\AuthenticationException;

class InvalidAuth extends AuthenticationException
{
    public static function Unauthorized()
    {
        return new static('Invalid username or password!.');
    }
}
