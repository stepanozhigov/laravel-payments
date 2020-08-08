{{--qwertypayment with('recipient:id,name,email')--}}
@extends('layouts.paymentsapp')

{{--  Archive  --}}
@section('content')

<div class="w-full mx-4">

    {{--PAYMENT NAV--}}
    <x-payment-nav-bar paymentService="qwertykassa" color="blue">
        <x-slot name="logo">
            <x-qwerty-payment-logo></x-qwerty-payment-logo>
        </x-slot>
    </x-payment-nav-bar>
    {{--/PAYMENT NAV--}}

    {{--GRID--}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-col-3 xl:grid-cols-4 gap-4 mb-4">
        @foreach($qwertypayments as $key=>$payment)
            <x-qwerty-payment-grid-item :payment="$payment"></x-qwerty-payment-grid-item>
        @endforeach
    </div>
    {{--/GRID--}}

    {{--PAGINATOR--}}
    {{ $qwertypayments->links('vendor.pagination.simple-tailwind') }}
    {{--/PAGINATOR--}}

</div>
@endsection
