{{-- oldpayment with('recipient:id,name,email')->with('sender:id,name,email') --}}
@extends('layouts.paymentsapp')

@section('content')
<div class="w-full mx-4">
    {{--PAYMENT NAV--}}
    <x-payment-nav-bar paymentService="oldpay" color="purple">
        <x-slot name="logo">
            <x-old-payment-logo></x-old-payment-logo>
        </x-slot>
    </x-payment-nav-bar>
    {{--/PAYMENT NAV--}}

    <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 mx-auto">

        <div class="mb-6">
            @if(session('success') && session('signature'))
                {{--  MESSAGE  --}}
                <x-old-payment-message type="success" :message="session('success') ?? 'No message received'" :signature="session('signature') ?? 'No signature received'"></x-old-payment-message>
                {{--  /MESSAGE  --}}
            @endif
        </div>

        {{--  Payment details  --}}
        <x-old-payment-single-item :payment="$oldpayment"></x-old-payment-single-item>
    </div>
    {{--  /Payment details  --}}

</div>
@endsection
