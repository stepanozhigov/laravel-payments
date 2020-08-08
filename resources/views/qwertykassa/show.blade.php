{{-- qwertypayment with('recipient:id,name,email')->with('sender:id,name,email') --}}
@extends('layouts.paymentsapp')

@section('content')
<div class="w-full mx-4">
    {{--PAYMENT NAV--}}
    <x-payment-nav-bar paymentService="qwertykassa" color="blue">
        <x-slot name="logo">
            <x-qwerty-payment-logo></x-qwerty-payment-logo>
        </x-slot>
    </x-payment-nav-bar>
    {{--/PAYMENT NAV--}}

    <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 mx-auto">

        <div class="mb-6">
            @if(session('success') && session('signature'))
                {{--  MESSAGE  --}}
                <x-qwerty-payment-message type="success" :message="session('success') ?? 'No message received'" :signature="session('signature') ?? 'No signature received'"></x-qwerty-payment-message>
                {{--  /MESSAGE  --}}
            @endif
        </div>

        {{--  Payment details  --}}
        <x-qwerty-payment-single-item :payment="$qwertypayment"></x-qwerty-payment-single-item>
    </div>
    {{--  /Payment details  --}}

</div>
@endsection
