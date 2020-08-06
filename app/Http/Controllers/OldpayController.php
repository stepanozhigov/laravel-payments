<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OldpayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function form() {
        return view('oldpay.form');
    }

    public function pay(Request $request) {
        //validate input
        $request->validate([
            'name' => 'required|min:3|max:255',
            'amount' => 'required|numeric',
            'order_id'=>'required|numeric',
            'sign'=>'required'
        ]);
        dd($request->all());
        //http request to https://xyz-payment.ru/pay

        //success result
        $result = [
            'id'=>'1',
            'name'=>'Test Test',
            'transaction_id'=>'100',
            'sign'=>''
        ];
        return redirect()->route('oldpay.form')
            ->with(['message'=>'Old Pay transaction complete...'])
            ->withResult($result);
    }
}
