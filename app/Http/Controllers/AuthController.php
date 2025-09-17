<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HtttpResponses;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HtttpResponses;

    public function login()
    {
        return 'This is the login method from AuthController';
    }

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API token of'.$user->name)->plainTextToken,
        ]);
    }

    public function logout()
    {
        return response()->json('This is the logout method from AuthController');
    }
}
