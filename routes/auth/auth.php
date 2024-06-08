<?php

use Illuminate\Support\Facades\Route;

//Авторизация пользователя JWT
Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth',

], function () {

    Route::post('login', 'user\auth\UserAuthController@login');
    Route::post('register', 'user\auth\UserAuthController@register');
    Route::post('logout', 'user\auth\UserAuthController@logout');
    Route::get('profile', 'user\auth\UserAuthController@userProfile');
    Route::post('refresh', 'user\auth\UserAuthController@refresh');

    Route::post('login/client', 'client\auth\ClientAuthController@login');
    Route::post('register/client', 'client\auth\ClientAuthController@register');
    Route::post('verification/client', 'client\auth\ClientAuthController@verifyCode');
    Route::post('logout/client', 'client\auth\ClientAuthController@logout');
    Route::get('profile/client', 'client\auth\ClientAuthController@userProfile');
    Route::post('refresh/client', 'client\auth\ClientAuthController@refresh');
});


