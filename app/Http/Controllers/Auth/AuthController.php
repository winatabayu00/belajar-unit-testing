<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Authentication;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request, Authentication $authentication)
    {
        /**
         * Kita buat validasi request yang dikirim oleh user
         */
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);

        if (!$authentication->handle($request)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('Laravel Password Grant Client')->accessToken, // token digunakan untuk mengakses API
        ]);
    }
}
