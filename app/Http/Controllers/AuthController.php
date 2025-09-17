<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HtttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HtttpResponses;

    public function login(LoginUserRequest $request)
    {
        $validated = $request->validated();

        if (! Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            return $this->error('', 'Invalid credentials', 401);
        }

        $user = User::where('email', $validated['email'])->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API token of '.$user->name)->plainTextToken,
        ], 'User has logged in successfully', 200);
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
            'token' => $user->createToken('API token of '.$user->name)->plainTextToken,
        ], 'User has been created successfully', 201);
    }

    public function logout()
    {
        $user = Auth::user();

        $user->tokens()
            ->where('id', $user->currentAccessToken()?->id)
            ->delete();

        return $this->success('', 'User has logged out successfully');
    }
}
