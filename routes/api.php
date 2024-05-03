<?php

use Illuminate\Support\Facades\Route;

require_once __DIR__.'/client/client.php';
require_once __DIR__.'/auth/auth.php';
require_once __DIR__.'/client/dashboard.php';
require_once __DIR__.'/outSideService/outSideService.php';
require_once __DIR__.'/user/user.php';

// Роут без применения middleware 'auth:api'
Route::post('/maps/coordinate_receive', 'App\Http\Controllers\outsideService\UtilXMLController@coordinate_to_from');
Route::post('/baf', 'App\Http\Controllers\outsideService\BafController@MainRoute');

