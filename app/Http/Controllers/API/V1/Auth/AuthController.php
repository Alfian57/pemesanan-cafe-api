<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login for Admin and Cashier
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (! Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }

        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successfully',
        ]);
    }
}
