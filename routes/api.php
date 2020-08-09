<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PaymentServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware(['auth:api'])->group(function() {
    //QWERTY API


    //OLDPAY API
    Route::get('get-status/{transaction_id}', 'OldpayController@getStatus');
    Route::post('get-status', 'API\PaymentServiceController@getStatus');
    Route::post('create', 'API\PaymentServiceController@create');
});



