{{-- xyzpayment with('recipient:id,name,email')->with('sender:id,name,email') --}}
@extends('layouts.paymentsapp')

@section('content')
<div class="w-full mx-4">
    {{--PAYMENT NAV--}}
    <x-payment-nav-bar paymentService="xyzpayment">
        <x-slot name="logo">
            <x-xyz-payment-logo></x-xyz-payment-logo>
        </x-slot>
    </x-payment-nav-bar>
    {{--/PAYMENT NAV--}}

    <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 mx-auto">

        <div class="mb-6">
            @if(session('success') && session('secretkey'))
                {{--  MESSAGE  --}}
                <x-xyz-payment-message type="success" :message="session('success')" :secretkey="session('secretkey')"></x-xyz-payment-message>
                {{--  /MESSAGE  --}}
            @endif
        </div>

        {{--  Payment details  --}}
        <x-xyz-payment-single-item :payment="$xyzpayment"></x-xyz-payment-single-item>
    </div>
    {{--  /Payment details  --}}

</div>
@endsection
