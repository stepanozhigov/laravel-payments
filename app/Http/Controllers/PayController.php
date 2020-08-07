<?php

namespace App\Http\Controllers;

use App\XYZPayment;
use Illuminate\Http\Request;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function pay(Request $request) {

        $access_keys = [
            'YXZPayment'=>'ce2c7e660754cc4e325564aab86d11d8',
            'QwertyPayment'=>'mh2c7e660754cc4e325564aab86d20d1'
        ];
        $model = array_search($request->access_key,$access_keys);
//dd($model);
        if($model && $request->access_key && $request->secret_key) {
            if($model == 'YXZPayment') {
                return response()->json([
                    //'transaction_id'=>rand(1,4294967295),
                    'transaction_id'=>self::generateTransactionId('transaction_id'),
                    'sign' => $model.'&'.$request->access_key.'&'.$request->secret_key
                ],200);
            } elseif ($model == 'QwertyPayment') {
                return response()->json([
                    'payment_id'=>rand(1,4294967295),
                    'sign' => $model.'&'.$request->access_key.'&'.$request->secret_key
                ],200);
            }
        }
    }

    static function generateTransactionId($field) {
        $rnd_num = rand(1,4294967295);
        $count = XYZPayment::where($field,$rnd_num)->get()->count();
        if($count>0) {
            self::generateTransactionId($field);
        } else {
            return $rnd_num;
        }
    }
}
