@extends('layouts.paymentsapp')

@section('content')
    <div class="flex flex-row justify-center items-center w-full flex-wrap lg:flex-no-wrap">
{{--    XYZ PAYMENT    --}}
        <a href="{{route('xyzpayment.form')}}" class="w-full lg:w-1/3 m-4">
            <div class="relative overflow-hidden bg-orange-500 rounded-lg shadow-lg text-white px-8 py-24">
                <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                    <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"></rect>
                    <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"></rect>
                </svg>
                <div class="flex flex-col justify-center items-center">
                    <i class="fi-xnluxl-playstore text-6xl fill-current"></i>
                    <h3 class="block font-light text-2xl text-center">{{__('XYZ Payment')}}</h3>
                </div>
            </div>
        </a>
{{--    QWERTY-Kassa    --}}
        <a href="{{route('qwertykassa.form')}}" class="w-full lg:w-1/3 m-4">
            <div class="flex-shrink-0 relative overflow-hidden bg-teal-500 rounded-lg shadow-lg text-white px-8 py-24">
                <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                    <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"></rect>
                    <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"></rect>
                </svg>
                <div class="flex flex-col justify-center items-center">
                    <i class="fi-xnsuxl-apple text-6xl fill-current"></i>
                    <h3 class="block font-light text-2xl text-center">{{__('QWERTY-Kassa')}}</h3>
                </div>
            </div>
        </a>
{{--    OLD PAY    --}}
        <a href="{{route('oldpay.form')}}" class="w-full lg:w-1/3 m-4">
            <div class="flex-shrink-0 relative overflow-hidden bg-purple-500 rounded-lg shadow-lg text-white px-8 py-24">
                <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
                    <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"></rect>
                    <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"></rect>
                </svg>
                <div class="flex flex-col justify-center items-center">
                    <i class="fi-xnluxl-change text-6xl fill-current"></i>
                    <h3 class="block font-light text-2xl text-center">{{__('OLDPay')}}</h3>
                </div>
            </div>
        </a>
    </div>
@endsection
