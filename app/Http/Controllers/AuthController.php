<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:4'
        ]);

        $user = User::where('email', $loginUserData['email'])->first(['id', 'name', 'email', 'password']);

        if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
            Log::info("[Auth] Attempted admin login failed. Email: " . $loginUserData['email']);

            return response(
                [
                    'status' => 'failed',
                    'message' => 'Invalid credentials.',
                    'data' => null
                ],
                401
            );
        }

        $token = $user->createToken($user->name . '-APSX#25')->plainTextToken;
        $user->role = 'Admin';

        Log::info('[Auth] Admin ' . $user->name . ' logged in successfully. Data: ' . $user);

        unset($user->id);

        return response(
            [
                'status' => 'success',
                'message' => 'Admin authentication successful.',
                'data' => [
                    'client' => $user,
                    'token' => $token
                ]
            ],
            200
        );
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $token = $request->user()->createToken('bearer');
            Auth::user()->token = $token->plainTextToken;

            Log::info('[Payments] User ' . $request->email . ' logged in successfully. Data: ' . Auth::user());

            return response(
                [
                    'status' => 'success',
                    'message' => 'Authentication successful.',
                    'data' => Auth::user()
                ],
                200
            );
        } else {

            Log::info('[Payments] Attempted login failed. Data: ' . $request->all());

            return response(
                [
                    'status' => 'failed',
                    'message' => 'Please authenticate to continue.',
                    'data' => null
                ],
                401
            );
        }
    }
}
