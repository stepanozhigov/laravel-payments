{{--recipients--}}
{{--rates--}}
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

    {{--    FORM    --}}
    <div class="relative w-full bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

        {{--  JSON MESSAGE  --}}
        <div id="result-box" class="hidden absolute inset-0 flex flex-col items-center justify-center bg-blue-500 z-50 text-white text-center font-light text-xl p-6">
            <a href="#" id="close-box" class="absolute top-0 right-0 p-2">
                <svg viewBox="0 0 20 20" fill="currentColor" class="x-circle w-6 h-6"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </a>
            <h3 class="text-3xl">Payment Complete</h3>
            <div class="w-full md:w-1/2 lg:w-1/4 mx-auto m-6">
                <div class="flex justify-between items-center">
                    <p id="result-order_id">order_id</p>
                    <p>0</p>
                </div>
                <div class="flex justify-between items-center">
                    <p id="result-payment_id">payment_id</p>
                    <p>0</p>
                </div>
                <div class="flex justify-between items-center">
                    <p id="result-sum">sum</p>
                    <p>0</p>
                </div>
                <div class="flex justify-between items-center">
                    <p id="result-currency">currency</p>
                    <p>0</p>
                </div>
                <div class="flex justify-center items-center mt-4">
                    <a href="#" id="result-link" class="bg-white hover:bg-blue-100 text-blue-500 font-light py-2 px-6 border border-blue-500 rounded shadow">
                        View
                    </a>
                </div>
            </div>
        </div>
        {{--  /JSON MESSAGE  --}}

        <form id="qwertykassa-form" class="w-full md:w-1/2 lg:w-1/4 mx-auto" method="POST" action="{{route('qwertykassa.pay')}}" data-url="{{route('qwertykassa.form')}}">

            {{--      ERROR      --}}
            @if(session('fail') ?? '')
                <div class="flex bg-red-600 mb-4 w-full">
                    <div class="w-16 bg-red-700">
                        <div class="p-4">
                            <svg class="h-8 w-8 text-white fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M437.019 74.981C388.667 26.629 324.38 0 256 0S123.333 26.63 74.981 74.981 0 187.62 0 256s26.629 132.667 74.981 181.019C123.332 485.371 187.62 512 256 512s132.667-26.629 181.019-74.981C485.371 388.667 512 324.38 512 256s-26.629-132.668-74.981-181.019zM256 470.636C137.65 470.636 41.364 374.35 41.364 256S137.65 41.364 256 41.364 470.636 137.65 470.636 256 374.35 470.636 256 470.636z" fill="#FFF"/><path d="M341.22 170.781c-8.077-8.077-21.172-8.077-29.249 0L170.78 311.971c-8.077 8.077-8.077 21.172 0 29.249 4.038 4.039 9.332 6.058 14.625 6.058s10.587-2.019 14.625-6.058l141.19-141.191c8.076-8.076 8.076-21.171 0-29.248z" fill="#FFF"/><path d="M341.22 311.971l-141.191-141.19c-8.076-8.077-21.172-8.077-29.248 0-8.077 8.076-8.077 21.171 0 29.248l141.19 141.191a20.616 20.616 0 0 0 14.625 6.058 20.618 20.618 0 0 0 14.625-6.058c8.075-8.077 8.075-21.172-.001-29.249z" fill="#FFF"/></svg>
                        </div>
                    </div>
                <div class="w-auto text-black items-center p-4 text-white">
                    <span class="text-lg font-bold pb-4">
                    Error!
                    </span>
                    <p class="leading-tight text-white">
                    {{ session('fail') }}
                    </p>
                    </div>
                </div>
            @endif
            {{--      /ERROR      --}}

            @csrf
            <input type="hidden" name="secret_key" value="{{ Auth::user()->secret_key }}">

            {{--        RECIPIENT        --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    {{__('Recipient')}}
                </label>
                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('recipient_id') border-red-500 @enderror" id="recipient" name="recipient_id">
                    <option value="">Select Recipient...</option>
                    dd($recipients);
                    @foreach($recipients as $key=>$recipient)
                        <option value="{{ $recipient->id }}">{{ $recipient->name }}</option>
                    @endforeach
                </select>
                @error('recipient_id')
                <p class="text-red-500 text-xs italic mt-3">{{$message}}</p>
                @enderror
            </div>

            {{--        ORDER_ID        --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="order_id">
                    {{__('Order ID')}}
                </label>
                <input class="border border-gray-200 appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mr-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('order_id') border-red-500 @enderror" id="order_id" name="order_id" type="text" value="{{old('order_id')}}" placeholder="0.00" autocomplete="false">
                @error('order_id')
                <p class="text-red-500 text-xs italic mt-3">{{$message}}</p>
                @enderror
            </div>
            {{--       ROW        --}}
            <div class="mb-4 flex flex-row">

                {{--       SUM         --}}
                <div class="w-1/2 mr-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="sum">
                        {{__('Amount')}}
                    </label>
                    <input class="border border-gray-200 appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mr-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('sum') border-red-500 @enderror" id="sum" name="sum" type="text" value="{{old('amount')}}" placeholder="0.00" autocomplete="false">
                    @error('sum')
                    <p class="text-red-500 text-xs italic mt-3">{{$message}}</p>
                    @enderror
                </div>

                {{--       Currency         --}}
                <div class="w-1/2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="currency">
                        {{__('Currency')}}
                    </label>
                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="currency" name="currency">
                        @foreach($rates as $val=>$text)
                            <option value="{{ $val }}">(x{{ $text }}) {{$val}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            {{--       /ROW        --}}
            {{--BUTTON PAY --}}
            <div class="flex items-center justify-between">
                <button class="h-full bg-blue-500 hover:bg-blue-300 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline" type="submit">
                    {{ __('Pay') }}
                </button>
            </div>
        </form>
    </div>
    <p class="text-center text-gray-500 text-xs">
        &copy; Stepan Ozhigov
    </p>
</div>
@endsection
@push('scripts')
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="{{asset('js/qwertypayment.form.js')}}"></script>
@endpush
