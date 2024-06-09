<?php

use App\Http\Controllers\user\auth\LoginController;
use App\Http\Controllers\user\document\GenerateDocument;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\externalServices\Client\Order\Order as OrderClient;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes/web.php

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/generate-document/docx', [GenerateDocument::class, 'createDocs']);
Route::get('/generate-document/pdf', [GenerateDocument::class, 'createPDF']);
Route::get('/order/{orderGuid}/client', [OrderClient::class, 'getOrder'])->name('order.client');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/order/{orderGuid}/client/shorten', [OrderClient::class, 'createShortURL']);
// $router->group(['prefix' => 'api'], function () use ($router) {
// });
