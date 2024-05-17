<?php

use App\Http\Controllers\externalServices\BafController;
use App\Http\Controllers\externalServices\Gis;
use Illuminate\Support\Facades\Route;

require_once __DIR__.'/client/client.php';
require_once __DIR__.'/auth/auth.php';
require_once __DIR__.'/client/dashboard.php';
require_once __DIR__.'/outSideService/outSideService.php';
require_once __DIR__.'/user/user.php';

// Роут без применения middleware 'auth:api'
Route::post('/maps/coordinate_receive', [Gis::class, 'searchPointAddress']);

//baf controller
Route::post('/baf/find-bin', [BafController::class, 'findBin']);
Route::post('/baf/list-contracts', [BafController::class, 'listContracts']);
Route::post('/baf/detail-contract', [BafController::class, 'detailContract']);
Route::post('/schedule/bin/get', [BafController::class, 'getClient']);
Route::post('/schedule/bin/set', [BafController::class, 'getClient']);
