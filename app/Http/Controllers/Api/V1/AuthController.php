<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
              'message' => 'Unauthorized'
            ], 401);
        }
        return response()->json([
            'token' => $request->user()->createToken($request->device)->plainTextToken,
            'message' => 'Success'
        ]);
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'device' => 'required|string|max:255',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $token = $user->createToken($validated['device'])->plainTextToken;
        $res = [
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
        return $this->success($res, 'OK');
    }
    public function validateLogin(Request $request)
    {
        return $request->validate([
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'device' => 'required|string|max:255',
        ]);
    }
}
