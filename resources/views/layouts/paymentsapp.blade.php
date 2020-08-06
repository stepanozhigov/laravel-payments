<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="h-screen flex flex-col">
        {{--    LOGO    --}}
        <nav class="text-center md:flex md:items-center md:justify-between md:flex-wrap bg-teal-500 p-4">
            <a href="{{route('main')}}">
                <div class="flex items-center justify-center flex-shrink-0 text-white mb-6 md:mb-0">
                    <i class="fi-xnsuxl-credit-card-thin text-4xl mr-2"></i>
                    <span class="font-semibold text-xl tracking-tight">Money Transfer</span>
                </div>
            </a>

            @auth
            <div class="flex items-center justify-center w-full md:w-auto">
                {{--       BALANCE     --}}
                <div class="flex text-white mr-4">
                    <i class="fill-current fi-xnlu2x-database-solid mr-2"></i>
                    <p>{{Auth::user()->balance}} RUB</p>
                </div>
                {{--       USER     --}}
                <div class="flex text-white mr-4">
                    <i class="fill-current fi-cnsu2x-user-tie-circle mr-2"></i>
                    <p>{{Auth::user()->name}}</p>
                </div>
                {{--       LOGOUT     --}}
                <a class="inline-block px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            @endauth

            {{--       REGISTER/LOGIN     --}}
            @guest
                <div class="flex items-center">
                    <div class="mr-2">
                        <a href="{{route('login')}}" class="text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white">Login</a>
                    </div>
                    <div>
                        <a href="{{route('register')}}" class="text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white">Register</a>
                    </div>
                </div>
            @endguest

        </nav>

        <section class="py-4 flex flex-grow bg-gray-100">
            @yield('content')
        </section>
    </div>
    <script defer src="https://friconix.com/cdn/friconix.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
