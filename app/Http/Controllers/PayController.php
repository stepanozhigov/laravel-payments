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
        if($request->has('access_key')) {
            $model = array_search($request->access_key,$access_keys);
        } else {
            $signature = $request->header('X-SIGNATURE');
            $model = array_search($signature,$access_keys);
            //return response()->json(['test'=>$model]);
        }
        if($model == 'XYZPayment') {
            return response()->json([
                'transaction_id'=>self::generateTransactionId('App\XYZPayment','transaction_id'),
                'sign' => Hash::make($model.$request->access_key.$request->secret_key),
            ],200);
        } elseif ($model == 'QwertyPayment') {
            return response()
                ->json([
                'payment_id'=>self::generateTransactionId('App\QwertyPayment','payment_id'),
                'sum'=>$request->sum
            ],200)->header('X-SIGNATURE',bcrypt($signature));
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
