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

        $access_key = 'ce2c7e660754cc4e325564aab86d11d8';
        if($access_key == $request->access_key && $request->secret_key) {
            return response()->json([
                'transaction_id'=>rand(1,1000)
            ],200);
        }
    }

    public function generateTransactionId() {
        $rnd_num = rand(1,4294967295);
        $trans = XYZPayment::where('transaction_id',$rnd_num)->get();
        if($trans) {
            $this->generateTransactionId();
        } else {
            return $rnd_num;
        }
    }


}
