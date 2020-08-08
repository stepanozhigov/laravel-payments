<div class="oldpayment flex flex-col items-center justify-center bg-white p-4 shadow rounded-lg">
    {{--  AMOUNT ROW  --}}
    <div class="relative w-full flex items-center justify-center bg-purple-500 text-white font-normal text-center pt-2 pb-5">
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

        <div class="absolute rounded-full border-white border-.5 bg-purple-500 text-white z-10 top-100p -mt-4 p-4">
                <span class="font-medium">
                    {{$payment->sum}} RUB
                </span>
        </div>
    </div>
    {{--  /AMOUNT ROW  --}}

    {{--  ROW  --}}
    <div class="w-full pt-16">
        <div class="flex flex-row justify-between items-center">
            {{--TRANS--}}
            <div class="relative transaction flex items-center justify-center p-2 text-purple-500 w-full">
                <div class="transaction-logo mr-2">
                    <i class="fi-xnluxl-address-card text-2xl"></i>
                </div>
                <p class="font-normal text-sm leading-none">#{{$payment->transaction_id}}</p>
                <div class="absolute text-center opacity-0 hover:opacity-100 inset-0 bg-gray-800 text-black bg-purple-500 text-white flex items-center justify-center font-medium cursor-pointer">Payment ID</div>
            </div>
            {{--/TRANS--}}
            {{--ORDER--}}
            <div class="relative order flex items-center justify-center p-2 text-purple-500 w-full">
                <div class="transaction-logo mr-2">
                    <i class="fi-xnluxl-shopping-cart text-2xl"></i>
                </div>
                <p class="font-normal text-sm leading-none">#{{$payment->order_id}}</p>
                <div class="absolute text-center opacity-0 hover:opacity-100 inset-0 bg-gray-800 text-black bg-purple-500 text-white flex items-center justify-center font-medium cursor-pointer">Order ID</div>
            </div>
            {{--/ORDER--}}
            {{--AGO--}}
            <div class="relative date flex items-center justify-center p-2 text-purple-500 w-full">
                <div class="date-logo mr-2">
                    <i class="fi-xnluxl-calendar-clock text-2xl"></i>
                </div>
                <p class="font-normal text-sm leading-none">{{$payment->formatTimeAgo()}}</p>
                <div class="absolute text-center opacity-0 hover:opacity-100 inset-0 bg-gray-800 text-black bg-purple-500 text-white flex items-center justify-center font-medium cursor-pointer">Created Ago</div>
            </div>
            {{--/AGO--}}
        </div>
        {{--  /ROW  --}}
    </div>
    {{--  /ROW  --}}
</div>
