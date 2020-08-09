<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\OldPay;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Zttp\Zttp;

class PaymentServiceController extends Controller
{

    //POST TO OLDPAY PAYMENT SERVICE
    public function getStatus(Request $request) {
        //check access key
        if($request->header('X-SECRET-KEY') == config('services.oldpay.key')) {
            $transaction = OldPay::where('transaction_id',$request->transaction_id)->first();
            if($transaction) {
                return response()->json([
                    'status'=>'success',
                    'sum'=>$transaction->sum,
                    'order_id'=>$transaction->order_id
                ],200);
            } else {
                return response()->json([
                    'status'=>'fail'
                ],404);
            }
        } else {
            return response()->json([
                'status'=>'fail'
            ],401);
        }

    }

    //CREATE OLDPAY TRANSACTION
    public function create(Request $request) {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'order_id' => 'required|numeric',
            'sum' => ['required','numeric', function($attribute, $value, $fail) {
                if((Auth::user()->balance) - $value < 0 ) {
                    $fail("Check your balance");
                }
            }],
        ]);
        //make Zttp request to payment service
        $response = Zttp::withHeaders([
            'X-SECRET-KEY'=>config('services.oldpay.key')
        ])->post('old-pay.ru/pay', [
            'sum' => $request->sum,
            'order_id' => $request->order_id,
            'secret_key' => Auth::user()->secret_key
        ]);

        if($response->status() === 200) {
            $paymentResponse = $response->json();
            //update sender balance
            $sender = Auth::user();
            $sender->balance -= $request->sum;
            $sender->save();

            //update recipient balance
            $recipient = User::findOrFail($request->recipient_id);
            $recipient->balance += $request->sum;
            $recipient->save();
            if(Hash::check(config('services.oldpay.key'),$response->header('X-SECRET-KEY'))) {
                //save transaction
                $transaction = OldPay::create([
                    'transaction_id'=>$paymentResponse['transaction_id'],
                    'order_id'=>$request->order_id,
                    'sender_id'=>Auth::user()->id,
                    'recipient_id'=>$request->input('recipient_id'),
                    'sum'=>$request->input('sum')+0.00
                ]);
                //success result
                return response()->json([
                    'created'=>true,
                    'message'=>'Transaction complete...',
                    'signature'=>$response->header('X-SECRET-KEY'),
                    'transaction'=>$transaction

                ],201);
            } else {
                //hash check failed
                return response()->json([
                    'created'=>false,
                    'message'=>'Hash check failed...Check your access key',
                ],401);
            }
        }
        //payment service failure
        return response()->json([
            'created'=>false,
            'message'=>'Payment Server error...Try again later',
        ],500);
    }

}
