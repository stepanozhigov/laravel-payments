<?php

namespace App\Http\Controllers;

use App\QwertyPayment;
use App\User;
use App\XYZPayment;
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

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function form() {
        $recipients = User::where('id','!=',Auth::user()->id)->get();
        return view('qwertykassa.form',[
            'recipients'=>$recipients,
            'rates'=>self::$rates
        ]);
    }

    public function show($id) {
        return view('qwertykassa.show',
            ['qwertypayments'=>QwertyPayment::with('recipient:id,name,email')->with('sender:id,name,email')->findOrFail($id)]);
    }

    public function pay(Request $request) {
        //validate inputs
        $request->validate([
            'recipient_id' => 'required|numeric',
            'order_id' => 'required|numeric',
            'currency' => 'required',
            'sum' => ['required','numeric', function($attribute, $value, $fail) {
                if((Auth::user()->balance) - $value < 0 ) {
                    $fail("Check your balance");
                }
            }],
        ]);
        //calculate sum
        $rub_sum = $this->rates['$request->currency']*$request->sum;

        //make Zttp request to payment service
        $response = Zttp::asFormParams()->post('qwerty.ru/pay', [
            'sum' => $rub_sum,
            'access_key' => config('services.qwertykassa.key'),
            'secret_key' => Auth::user()->secret_key
        ]);
        if($response->status() === 200) {
            $paymentResponse = $response->json();
            //update sender balance
            $sender = Auth::user();
            $sender->balance -= $request->amount;
            $sender->save();

            //update recipient balance
            $recipient = User::findOrFail($request->recipient_id);
            $recipient->balance += $request->amount;
            $recipient->save();

            $plain_hash = 'XYZPayment'.config('services.xyzpayment.key').Auth::user()->secret_key;
            if(Hash::check($plain_hash,$paymentResponse['sign'])) {
                //save transaction
                $xyzpayment = XYZPayment::create([
                    'transaction_id'=>$paymentResponse['transaction_id'],
                    'order_id'=>$request->order_id,
                    'sender_id'=>Auth::user()->id,
                    'recipient_id'=>$request->input('recipient_id'),
                    'amount'=>$request->input('amount')+0.00
                ]);
                //success result
                return redirect()->route('qwertykassa.show',['id'=>$xyzpayment->id])
                    ->withSuccess('Transaction complete...')->withSign($paymentResponse['sign']);
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
