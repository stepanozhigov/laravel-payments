<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function pay(Request $request) {

        $access_keys = [
            'XYZPayment'=>'ce2c7e660754cc4e325564aab86d11d8',
            'QwertyPayment'=>'mh2c7e660754cc4e325564aab86d20d1'
        ];
        $model = array_search($request->access_key,$access_keys);
        if($model && $request->access_key && $request->secret_key) {
            if($model == 'XYZPayment') {
                return response()->json([
                    //'transaction_id'=>rand(1,4294967295),
                    'transaction_id'=>self::generateTransactionId('App\XYZPayment','transaction_id'),
                    'sign' => Hash::make($model.$request->access_key.$request->secret_key),
                ],200);
            } elseif ($model == 'QwertyPayment') {
                return response()->json([
                    'payment_id'=>self::generateTransactionId('App\XYZPayment','transaction_id'),
                    'sign' => bcrypt($model.$request->access_key.$request->secret_key)
                ],200);
            }
        }
    }

    static function generateTransactionId($class,$field) {
        $rnd_num = rand(1,4294967295);
        $count = $class::where($field,$rnd_num)->get()->count();
        if($count>0) {
            self::generateTransactionId($field);
        } else {
            return $rnd_num;
        }
    }
}
