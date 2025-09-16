<?php

namespace App\Http\Controllers;

use App\Traits\HtttpResponses;

class AuthController extends Controller
{
    use HtttpResponses;

    public function login()
    {
        return 'This is the login method from AuthController';
    }

    public function register()
    {
        return response()->json('This is the register method from AuthController');
    }

    public function logout()
    {
        return response()->json('This is the logout method from AuthController');
    }
}
