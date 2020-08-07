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
            return response()->json([
                'transaction_id'=>rand(1,4294967295),
//                'transaction_id'=>$this->generateTransactionId($model),
                'sign' => $model.'&'.$request->access_key.'&'.$request->secret_key
            ],200);
        }
    }

    public function generateTransactionId($model) {
        $rnd_num = rand(1,4294967295);
        $trans = $model::where('transaction_id',$rnd_num)->get();
        dd($trans);
        if($trans-count()>0) {
            $this->generateTransactionId($model);
        } else {
            return $rnd_num;
        }
    }


}
