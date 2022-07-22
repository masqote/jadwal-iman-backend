<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (!auth()->attempt($request->only('email','password'))) {
            throw new AuthenticationException();
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(
            [
                'message' => 'Hi '.$user->name.', welcome to home',
                'token' => $token, 
                'token_type' => 'Bearer', 
                'user' => $user,
            ]);

    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

    public function check_token(Request $request)
    {
        if (!auth()->check()) {

            return response()->json([
                'message' => 'Token Abis',
                'status' => false
            ]);

        }
        return response()->json([

                'message' => 'Token Ada woy',
                'status' => true

            ]);
    }

    // public function logout(Request $request)
    // {
    //     auth()->logout();
    // }
}
