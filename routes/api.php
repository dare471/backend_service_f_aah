<?php

use App\Http\Controllers\externalServices\Baf;
use App\Http\Controllers\externalServices\Gis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\externalServices\Client\Order\Order as OrderClient;

require_once __DIR__.'/client/client.php';
require_once __DIR__.'/auth/auth.php';
require_once __DIR__.'/client/dashboard.php';
require_once __DIR__.'/outSideService/outSideService.php';
require_once __DIR__.'/user/user.php';

// A route without using middleware will be written here as 'auth:api'
Route::post('/maps/coordinate_receive', [Gis::class, 'searchPointAddress']);

//baf controller
Route::post('/baf/find-bin', [Baf::class, 'findBin']);
Route::post('/baf/list-contracts', [Baf::class, 'listContracts']);
Route::post('/baf/detail-contract', [Baf::class, 'detailContract']);
Route::post('/schedule/bin/get', [Baf::class, 'getClient']);
Route::post('/schedule/bin/set', [Baf::class, 'getClient']);

//OrderService status for the client sent via SMS
Route::get('/order/{orderGuid}/client/', [OrderClient::class, 'getOrder']);
