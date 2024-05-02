<?php

namespace App\Http\Controllers;

use App\Dto\BaseOutput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Usuário não autorizado!'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;


        $response = new BaseOutput(
            "Usuário logado com sucesso!", [
                'user' => $user,
                'token' => $token,
            ]
        );

        return $response->render(200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $response = new BaseOutput(
            "Usuário deslogado com sucesso!"
        );

        return $response->render(200);
    }
}
