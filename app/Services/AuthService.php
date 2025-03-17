<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        $user = $this->authRepository->createUser($data);

        if (!$user) {
            return response()->json(['message' => 'Registration failed'], 500);
        }

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'message' => 'Registration successful'
        ], 201);
    }

    public function login(array $credentials)
    {
        $user = $this->authRepository->findUserByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            abort(response()->json([
                'message' => 'Invalid email or password',
                'errors' => ['credential' => ['These credentials do not match our records.']]
            ], 401));
        }

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token
        ], 200);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return ['message' => 'Successfully logged out'];
    }
}