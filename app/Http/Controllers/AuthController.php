<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $token = $user->createToken('WarehouseAppToken')->accessToken;

        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $token,
            'api_urls' => [
                'transit' => 'http://api-transit.example.com',
                'store' => 'http://api-store.example.com',
            ],
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('WarehouseAppToken')->accessToken;

            return response()->json([
                'user' => new UserResource($user),
                'access_token' => $token,
                'api_urls' => [
                    'transit' => 'http://api-transit.example.com',
                    'store' => 'http://api-store.example.com',
                ],
            ]);
        } else {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Cierre de sesión exitoso']);
    }
}
