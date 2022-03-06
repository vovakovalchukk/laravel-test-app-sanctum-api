<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequestLogin;
use App\Http\Requests\AuthRequestRegister;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequestLogin $request)
    {
        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response([
                'message' => 'Bad creds',
            ], 401);
        };

        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function register(AuthRequestRegister $request)
    {
        $user = User::create($request->only([
            'name',
            'email',
            'password',
        ]));

        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'succsess',
        ], 203);
    }
}
