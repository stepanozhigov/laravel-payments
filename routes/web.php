<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();

//Home
Route::get('/', 'HomeController@index')->name('main');

//Payments
Route::get('/payments', 'PaymentController@index')->name('payments');

////Payments XYZ Payment
Route::get('xyzpayment', 'XYZPaymentController@form')->name('xyzpayment.form')->middleware('auth');
Route::post('xyzpayment', 'XYZPaymentController@pay')->name('xyzpayment.pay')->middleware('auth');
Route::get('xyzpayment/sent', 'XYZPaymentController@sent')->name('xyzpayment.sent')->middleware('auth');
Route::get('xyzpayment/received', 'XYZPaymentController@received')->name('xyzpayment.received')->middleware('auth');
Route::get('xyzpayment/{id}',['uses'=>'XYZPaymentController@show', 'as'=>'xyzpayment.show'])->where('id','[0-9]+')->middleware('auth');

////Payments QWERTY Kassa
Route::get('qwertykassa', 'QwertykassaController@form')->name('qwertykassa.form')->middleware('auth');
Route::post('qwertykassa', 'QwertykassaController@apiPay')->name('qwertykassa.pay')->middleware('auth:api');
Route::get('qwertykassa/sent', 'QwertykassaController@sent')->name('qwertykassa.sent')->middleware('auth');
Route::get('qwertykassa/received', 'QwertykassaController@received')->name('qwertykassa.received')->middleware('auth');
Route::get('qwertykassa/{id}',['uses'=>'QwertykassaController@show', 'as'=>'qwertykassa.show'])->where('id','[0-9]+')->middleware('auth');

////Payments OLD Pay
Route::get('oldpay', 'OldpayController@form')->name('oldpay.form')->middleware('auth');
//Route::post('oldpay', 'OldpayController@pay')->name('oldpay.pay')->middleware('auth');
Route::post('oldpay', 'API\PaymentServiceController@create')->name('oldpay.pay')->middleware('auth');
Route::get('oldpay/sent', 'OldpayController@sent')->name('oldpay.sent')->middleware('auth');
Route::get('oldpay/received', 'OldpayController@received')->name('oldpay.received')->middleware('auth');
Route::get('oldpay/{id}',['uses'=>'OldpayController@show', 'as'=>'oldpay.show'])->where('id','[0-9]+')->middleware('auth');

//PAYMENT REMOTE SERVICE
//https://xyz-payment.ru/pay
//https://qwerty.ru/pay
Route::post('pay',[
    'uses'=>'PayController@pay',
    'as'=>'pay'
]);

//OTHER ROUTES
//Route::get('{path}',function() {
//    return redirect('/');
//})->where('path','[A-Za-z\-\.\_\/]+');
