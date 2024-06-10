<?php

use App\Http\Controllers\externalServices\GetClientAndContract;
use App\Http\Controllers\externalServices\GetDistanceWithAdress;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\externalServices\Client\Contract\ContractMainLayer as OrderClient;

require_once __DIR__.'/client/client.php';
require_once __DIR__.'/auth/auth.php';
require_once __DIR__.'/client/dashboard.php';
require_once __DIR__.'/outSideService/outSideService.php';
require_once __DIR__.'/user/user.php';

// A route without using middleware will be written here as 'auth:api'
Route::post('/maps/coordinate_receive', [GetDistanceWithAdress::class, 'searchPointAddress']);

//baf controller
Route::post('/baf/find-bin', [GetClientAndContract::class, 'findBin']);
Route::post('/baf/list-contracts', [GetClientAndContract::class, 'listContracts']);
Route::post('/baf/detail-contract', [GetClientAndContract::class, 'detailContract']);
Route::post('/schedule/bin/get', [GetClientAndContract::class, 'getClient']);
Route::post('/schedule/bin/set', [GetClientAndContract::class, 'getClient']);

//OrderService status for the client sent via SMS
Route::get('/order/{orderGuid}/client/', [OrderClient::class, 'getOrder']);
