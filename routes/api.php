<?php

use App\Http\Controllers\outsideService\BafClientController;
use App\Http\Controllers\outsideService\StatGovClientController;
use Illuminate\Support\Facades\Route;

require_once __DIR__.'/client/client.php';
require_once __DIR__.'/auth/auth.php';
require_once __DIR__.'/client/dashboard.php';
require_once __DIR__.'/outSideService/outSideService.php';
require_once __DIR__.'/user/user.php';

// Роут без применения middleware 'auth:api'
Route::post('/maps/coordinate_receive', 'App\Http\Controllers\outsideService\UtilXMLController@coordinate_to_from');
Route::post('/schedule/bin/get', [StatGovClientController::class, 'getClient']);
Route::post('/schedule/bin/set', [StatGovClientController::class, 'getClient']);
//baf controller
Route::post('/baf/find-bin', [BafClientController::class, 'findBin']);
Route::post('/baf/list-contracts', [BafClientController::class, 'listContracts']);
Route::post('/baf/detail-contract', [BafClientController::class, 'detailContract']);

