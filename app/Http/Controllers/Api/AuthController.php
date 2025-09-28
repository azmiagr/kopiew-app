<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ResponseHelper;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = Auth::guard('api')->login($user);

        return ResponseHelper::success(['token' => $token], "Successfully registered and logged in", 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return ResponseHelper::success(['token' => $token], "Logged in successfully");
    }

    public function logout()
    {
        try {
            Auth::guard('api')->logout();
            return ResponseHelper::success(null, "Logged out successfully");
        } catch (JWTException $e) {
            return ResponseHelper::error("Failed to log out", $e->getCode(), $e->getMessage());
        }
    }

    protected function respondWithToken($token, $status = 200)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>  config('jwt.ttl') * 60,
        ], $status);
    }
}
