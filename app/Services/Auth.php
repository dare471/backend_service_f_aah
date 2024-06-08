<?php

namespace App\Services;
use App\Models\users\Users;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class Auth
{
    public function login($credentials)
    {
        foreach (['email', 'phone', 'bin'] as $field) {
            if (!empty($credentials[$field])) {
                if ($token = auth('api')->attempt([$field => $credentials[$field], 'password' => $credentials['password']])) {
                    return $token;
                }
            }
        }
        return false;
    }

    public function register($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'bin' => 'required|string|unique:users',
            'phone' => 'required|string|max:16',
            'email' => 'required|email|unique:users|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        $user = Users::create([
            'name' => $data['name'],
            'bin' => $data['bin'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return ['token' => $token, 'message' => 'User successfully registered'];
    }
}
