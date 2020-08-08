{{--oldpayments with('recipient:id,name,email')--}}
@extends('layouts.paymentsapp')

{{--  Archive  --}}
@section('content')

<div class="w-full mx-4">

    {{--PAYMENT NAV--}}
    <x-payment-nav-bar paymentService="oldpay" color="purple">
        <x-slot name="logo">
            <x-old-payment-logo></x-old-payment-logo>
        </x-slot>
    </x-payment-nav-bar>
    {{--/PAYMENT NAV--}}

    {{--GRID--}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-col-3 xl:grid-cols-4 gap-4 mb-4">
        @foreach($oldpayments as $key=>$payment)
            <x-old-payment-grid-item :payment="$payment"></x-old-payment-grid-item>
        @endforeach
    </div>
    {{--/GRID--}}
    {{ $oldpayments->links('vendor.pagination.simple-tailwind') }}
</div>
@endsection
