<?php

namespace App\Http\Controllers\user\auth;

use App\Http\Controllers\Controller;
use App\Services\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthController extends Controller
{
    protected $authService;

    public function __construct(Auth $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|required_without_all:phone,bin|email',
            'phone' => 'sometimes|required_without_all:email,bin',
            'bin' => 'sometimes|required_without_all:email,phone',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'phone', 'bin', 'password');

        if (!$token = $this->authService->login($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $result = $this->authService->register($request->all());

        if (isset($result['errors'])) {
            return response()->json(['errors' => $result['errors']], 400);
        }

        return response()->json(['token' => $result['token'], 'message' => $result['message']]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    public function userProfile(Request $request)
    {
        try {
            $user = auth('api')->user();
            if (!$user) {
                return response()->json(['error' => 'user_not_found'], 404);
            }

            return response()->json([
                'head' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'user_not_found'], 404);
        }
    }
}
