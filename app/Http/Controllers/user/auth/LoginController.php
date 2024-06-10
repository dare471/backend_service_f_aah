<?php

namespace App\Http\Controllers\user\auth;

use App\Http\Controllers\Controller;
use App\Services\Staff\AuthServiceLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $authServiceLayer;

    public function __contruct(AuthServiceLayer  $authServiceLayer)
    {
        $this->authServiceLayer = $authServiceLayer;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
