<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateLastLogin;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;
    public function login(Request $request)
    {
        $fields = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if ($fields->fails()) {
            return $this->error($fields->errors(), 401);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Unauthorized', 401);
        }
        $res = [
            'token' => $request->user()->createToken('AUTH_TOKEN')->plainTextToken,
            'token_type' => 'Bearer'
        ];
        //dispatch(new UpdateLastLogin());
        return $this->success($res, 'OK');
    }
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return $this->success('', 'Logged out');
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
        event(new Registered($user));
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
