@extends('layouts.paymentsapp')

@section('content')
<div class="w-1/3 min-w-20 mx-auto">
    {{--  Other payments container  --}}
    <div class="flex flex-row items-stretch justify-center mb-4">
        {{--    XYZ Payment    --}}
        <a href="{{route('xyzpayment.form')}}" class="w-full lg:w-1/2 m-2 flex items-center justify-center">
            <div class="relative overflow-hidden bg-orange-500 hover:bg-orange-700 rounded-lg shadow-lg text-white p-6 w-full h-full">
                <svg class="absolute bottom-0 left-0" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                    <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"></rect>
                    <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"></rect>
                </svg>
                <div class="w-full flex flex-col justify-center items-center">
                    <i class="fi-xnluxl-playstore text-3xl fill-current mb-2"></i>
                    <h3 class="block font-light text-xl text-center leading-none">{{__('XYZ Payment')}}</h3>
                </div>
            </div>
        </a>

        {{--    QWERTY-Kassa    --}}
        <a href="{{route('qwertykassa.form')}}" class="w-full lg:w-1/2 m-2 flex items-center justify-center">
            <div class="flex-shrink-0 relative overflow-hidden bg-teal-500 hover:bg-teal-700 rounded-lg shadow-lg text-white p-6 w-full">
                <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                    <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"></rect>
                    <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"></rect>
                </svg>
                <div class="flex flex-col justify-center items-center">
                    <i class="fi-xnsuxl-apple text-3xl fill-current mb-2"></i>
                    <h3 class="block font-light text-xl text-center leading-none">{{__('QWERTY Kassa')}}</h3>
                </div>
            </div>
        </a>
    </div>

    {{--  OLD Pay Container  --}}
    <div class="min-w-20 flex flex-col justify-center">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{route('xyzpayment.pay')}}">
            {{--  LOGO  --}}
            <a href="{{route('oldpay.form')}}" class="mx-auto">
                <div class="relative overflow-hidden bg-purple-500 hover:bg-purple-700 rounded-lg shadow-lg text-white p-4 mb-4">
                    <svg class="absolute bottom-0 left-0" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                        <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"></rect>
                        <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"></rect>
                    </svg>
                    <div class="flex flex-col justify-center items-center">
                        <i class="fi-xnluxl-change text-3xl fill-current mb-2"></i>
                        <h3 class="block font-light text-xl text-center">{{__('OLD Pay')}}</h3>
                    </div>
                </div>
            </a>
            @csrf
            {{--        ORDER_ID        --}}
            <input type="hidden" id="order_id" name="order_id" value="123">
            {{--        SIGN        --}}
            <input type="hidden" id="sign" name="sign" value="123">
            {{--        NAME        --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    {{__('Name')}}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" id="name" name="name" type="text" placeholder="Name" value="{{old('name')}}">
                @error('name')
                <p class="text-red-500 text-xs italic mt-3">{{$message}}</p>
                @enderror
            </div>

            {{--        AMOUNT        --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">
                    {{__('Amount')}}
                </label>
                <div class="flex items-center justify-between items-center">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3  mr-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('amount') border-red-500 @enderror" id="amount" name="amount" type="text" value="{{old('amount')}}" placeholder="0.00">
                    @error('amount')
                    <p class="text-red-500 text-xs italic mt-3">{{$message}}</p>
                    @enderror

                    {{--       BUTTON REGISTER         --}}
                    <div class="flex items-center justify-between">
                        <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline" type="submit">
                            {{ __('Pay') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <p class="text-center text-gray-500 text-xs">
            &copy; Stepan Ozhigov
        </p>
    </div>
</div>
@endsection
