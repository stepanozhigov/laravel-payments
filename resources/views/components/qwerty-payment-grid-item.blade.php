{{--QwertyPayment $payment--}}
<a href="{{route('qwertykassa.show',['id'=>$payment->id])}}" class="transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-103 ">
    <div class="xyzpayment flex flex-col items-center justify-center bg-white p-4 shadow rounded-lg">

        {{--  AMOUNT ROW  --}}
        <div class="relative w-full flex items-center justify-center bg-blue-500 text-white font-normal text-center pt-2 pb-5">
            {{--RECIPIENT--}}
            <div class="user flex items-center justify-start p-2">
                <div class="user-photo mr-2">
                    <i class="fi-cnluxl-user-circle text-2xl"></i>
                </div>
                <div class="user-data flex flex-col">
                    <p class="font-normal text-xl leading-none text-left">{{$payment->recipient->name}}</p>
                    <p class="text-sm font-light">{{$payment->recipient->email}}</p>
                </div>
            </div>
            {{--/RECIPIENT--}}

            <div class="absolute rounded-full border-white border-.5 bg-blue-500 text-white z-10 top-100p -mt-4 p-4">
                <span class="font-medium">
                    {{$payment->sum}} {{$payment->currency}}
                </span>
            </div>
        </div>
        {{--  /AMOUNT ROW  --}}

        {{--  ROW  --}}
        <div class="w-full pt-16">
            <div class="flex flex-row justify-center items-center">
                {{--TRANS--}}
                <div class="transaction flex items-center justify-start p-2 text-blue-500">
                        <div class="transaction-logo mr-2">
                            <i class="fi-xnluxl-address-card text-2xl"></i>
                        </div>
                        <p class="font-normal text-sm leading-none">#{{$payment->payment_id}}</p>
                </div>
                {{--/TRANS--}}
                {{--ORDER--}}
                <div class="order flex items-center justify-start p-2 text-blue-500">
                    <div class="transaction-logo mr-2">
                        <i class="fi-xnluxl-shopping-cart text-2xl"></i>
                    </div>
                    <p class="font-normal text-sm leading-none">#{{$payment->order_id}}</p>
                </div>
                {{--/ORDER--}}
                {{--AGO--}}
                <div class="date flex items-center justify-start p-2 text-blue-500">
                    <div class="date-logo mr-2">
                        <i class="fi-xnluxl-calendar-clock text-2xl"></i>
                    </div>
                    <p class="font-normal text-sm leading-none">{{$payment->formatTimeAgo()}}</p>
                </div>
                {{--/AGO--}}
            </div>
            {{--  /ROW  --}}
        </div>
        {{--  /ROW  --}}
    </div>
</a>
