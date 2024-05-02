<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(public Auth $auth){}

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!$this->auth->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Usuário não autorizado!'
            ], 401);
        }

        $user = $this->auth->user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Usuário logado com sucesso!',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Usuário deslogado com sucesso!'
        ], 200);
    }
}
