<?php

namespace App\Http\Controllers;

use App\QwertyPayment;
use App\User;
use App\XYZPayment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Zttp\Zttp;
use Zttp\ZttpResponse;

class QwertykassaController extends Controller
{
    public static $rates = [
        'RUB'=>1,
        'USD'=>73.76,
        'EUR'=>87.20,
        'UAH'=>2.67
    ];

    public function form() {
        $recipients = User::where('id','!=',Auth::user()->id)->get();
        return view('qwertykassa.form',[
            'recipients'=>$recipients,
            'rates'=>self::$rates
        ]);
    }

    public function show($id) {
        return view('qwertykassa.show',
            ['qwertypayment'=>QwertyPayment::with('recipient:id,name,email')->with('sender:id,name,email')->findOrFail($id)]);
    }

    //WEB
    public function pay(Request $request) {
        //validate inputs
        $request->validate([
            'recipient_id' => 'required|numeric',
            'order_id' => 'required|numeric',
            'currency' => 'required',
            'sum' => 'required|numeric',
        ]);
        //calculate sum
        $rate = self::$rates[$request->currency];
        $sum = round($rate*$request->sum,2);
        //check balance
        if($sum > Auth::user()->balance) {
            return redirect()->route('qwertykassa.form')
                ->withFail('Check your balance...')
                ->withInput();
        }

        //make Zttp request to payment service
        $response = Zttp::withHeaders([
            'X-SIGNATURE'=>config('services.qwertykassa.key')
        ])->post('qwerty.ru/pay', [
            'sum' => $sum,
            'order_id' => $request->order_id,
            'currency' => $request->currency,
            'secret_key' => Auth::user()->secret_key
        ]);
        if($response->status() === 200) {
            $paymentResponse = $response->json();

            //update sender balance
            $sender = Auth::user();
            $sender->balance -= $sum;
            $sender->save();

            //update recipient balance
            $recipient = User::findOrFail($request->recipient_id);
            $recipient->balance += $sum;
            $recipient->save();

            //HASH CHECK
            if(Hash::check(config('services.qwertykassa.key'),$response->header('X-SIGNATURE'))) {
                //save transaction
                $xyzpayment = QwertyPayment::create([
                    'payment_id'=>$paymentResponse['payment_id'],
                    'order_id'=>$request->order_id,
                    'sender_id'=>Auth::user()->id,
                    'recipient_id'=>$request->input('recipient_id'),
                    'sum'=>$request->sum,
                    'rate'=>$rate,
                    'currency'=>$request->currency
                ]);
                //success result
                return redirect()->route('qwertykassa.show',['id'=>$xyzpayment->id])
                    ->withSuccess('Transaction complete...')->withSignature($response->header('X-SIGNATURE'));
            } else {
                //payment service failure
                return redirect()->route('qwertykassa.form')
                    ->withFail('Hash check failed...')
                    ->withInput();
            }
        }
        //payment service failure
        else {
            return redirect()->route('qwertykassa.form')
                ->withFail('Transaction failed...')
                ->withInput();
        }
    }

    //API
    //auth:api
    public function apiPay(Request $request) {
        //validate inputs
        $request->validate([
            'recipient_id' => 'required|numeric',
            'order_id' => 'required|numeric',
            'currency' => 'required',
            'sum' => 'required|numeric',
        ]);
        //calculate sum
        $rate = self::$rates[$request->currency];
        $sum = round($rate*$request->sum,2);
        //check balance
        if($sum > Auth::user()->balance) {
            return response()->json([
                'status'=>'fail',
                'message'=>'Check your balance...'
            ],400);
        }

        //make Zttp request to payment service
        $response = Zttp::withHeaders([
            'X-SIGNATURE'=>config('services.qwertykassa.key')
        ])->post('qwerty.ru/pay', [
            'sum' => $sum,
            'order_id' => $request->order_id,
            'currency' => $request->currency,
            'secret_key' => Auth::user()->secret_key
        ]);

        if($response->status() === 200) {
            $paymentResponse = $response->json();

            //update sender balance
            $sender = Auth::user();
            $sender->balance -= $sum;
            $sender->save();

            //update recipient balance
            $recipient = User::findOrFail($request->recipient_id);
            $recipient->balance += $sum;
            $recipient->save();

            //HASH CHECK
            if(Hash::check(config('services.qwertykassa.key'),$response->header('X-SIGNATURE'))) {
                //save transaction
                $payment = QwertyPayment::create([
                    'payment_id'=>$paymentResponse['payment_id'],
                    'order_id'=>$paymentResponse['order_id'],
                    'sender_id'=>Auth::user()->id,
                    'recipient_id'=>$request->recipient_id,
                    'sum'=>$paymentResponse['sum'],
                    'rate'=>$rate,
                    'currency'=>$paymentResponse['currency']
                ]);
                if($payment) {
                    return response()->json([
                        'status'=>'success',
                        'redirect_to'=>"/qwertykassa/".$payment->id,
                    ],201);
                } else {
                    return response()->json([
                        'status'=>'fail',
                        'message'=>'Server error...try later...'
                    ],500);
                }
            }
        } else {
            return response()->json([
                'status'=>'fail'
            ],500);
        }
    }

    public function sent() {
        $qwertypayments = QwertyPayment::where('sender_id',Auth::user()->id)->with('recipient:id,name,email')->orderBy('created_at','desc')->simplePaginate(12);
//        dd($xyzpayments);
        return view('qwertykassa.sent',['qwertypayments'=>$qwertypayments]);
    }

    public function received() {
        $qwertypayments = QwertyPayment::where('recipient_id',Auth::user()->id)->with('recipient:id,name,email')->orderBy('created_at','desc')->simplePaginate(12);
//        dd($xyzpayments);
        return view('qwertykassa.received',['qwertypayments'=>$qwertypayments]);
    }
}
