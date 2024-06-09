<?php // routes/client.php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['api', 'auth:api'],
    'namespace' => 'App\Http\Controllers\user',
], function () {
    Route::post('/product/index', 'product\ProductController@index');
    Route::post('/product/store', 'product\ProductController@store');
    Route::post('/product/all', 'product\ProductController@all');
    Route::post('/product/update', 'product\ProductController@update');
    Route::post('/prodcut/destroy', 'product\ProductController@destroy');
});