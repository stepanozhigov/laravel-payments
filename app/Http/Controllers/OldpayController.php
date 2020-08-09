<?php

namespace App\Http\Controllers;

use App\OldPay;
use App\QwertyPayment;
use App\User;
use App\XYZPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Zttp\Zttp;

class OldpayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function form() {
        $recipients = User::where('id','!=',Auth::user()->id)->get();
        return view('oldpay.form',[
            'recipients'=>$recipients
        ]);
    }

    public function pay(Request $request) {
        //validate input
        //validate balance
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
                return redirect()->route('oldpay.show',['id'=>$transaction->id])
                    ->withSuccess('Transaction complete...')
                    ->withSignature($response->header('X-SECRET-KEY'));
            } else {
                //payment service failure
                return redirect()->route('oldpay.form')
                    ->withFail('Hash check failed...')
                    ->withInput();
            }
        }
        //payment service failure
        return redirect()->route('oldpay.form')
            ->withFail('Transaction failed...')
            ->withInput();
    }

    public function getStatus($transaction_id) {
        //make Zttp request to payment service
        $response = Zttp::withHeaders([
            'X-SECRET-KEY'=>config('services.oldpay.key')
        ])->post('old-pay.ru/api/get-status', [
            'transaction_id' => $transaction_id,
            'secret_key' => Auth::user()->secret_key
        ]);
        if($response->status() === 200) {
            $res = $response->json();
            return response()->json([
                'status'=>$res['status'],
                'sum' => $res['sum'],
                'order_id'=>$res['order_id']
            ],200);
        }
        return response()->json([
            'status'=>'fail',
        ],404);
    }

    public function show($id) {
        return view('oldpay.show',
            ['oldpayment'=>OldPay::with('recipient:id,name,email')->with('sender:id,name,email')->findOrFail($id)]);
    }

    public function sent() {
        $xyzpayments = OldPay::where('sender_id',Auth::user()->id)->with('recipient:id,name,email')->orderBy('created_at','desc')->simplePaginate(12);
//        dd($xyzpayments);
        return view('oldpay.sent',['oldpayments'=>$xyzpayments]);
    }

    public function received() {
        $xyzpayments = OldPay::where('recipient_id',Auth::user()->id)->with('recipient:id,name,email')->orderBy('created_at','desc')->simplePaginate(12);
//        dd($xyzpayments);
        return view('oldpay.received',['oldpayments'=>$xyzpayments]);
    }
}
