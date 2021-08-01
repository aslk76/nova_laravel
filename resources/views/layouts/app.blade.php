<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NOVA SHIT') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark shadow-sm navbar-custom">
            <div class="container" style="padding-top: 0px; padding-bottom: 0px;">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/nova64.png" alt="NovaGaming" width="48">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    @if (Auth::user())
                        @if (Auth::user()->role <= 1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/mplus') }}">Mythic Plus</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/various') }}">Various Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/raids') }}">Raids</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Archives
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('/archives/mplus') }}">Mythic Plus</a>
                                    <a class="dropdown-item" href="{{ url('/archives/various') }}">Various Services</a>
                                    <a class="dropdown-item" href="{{ url('/archives/raids') }}">Raids</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Missing
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('/missing/mplus') }}">Mythic Plus</a>
                                    <a class="dropdown-item" href="{{ url('/missing/various') }}">Various Services</a>
                                    <a class="dropdown-item" href="{{ url('/missing/raids') }}">Raids</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/statistics') }}">Statistics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/balance') }}">Balance</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Payments
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('/payments') }}">This week payments</a>
                                    <a class="dropdown-item" href="{{ url('/missingPayments') }}">Pending payments</a>
                                </div>
                            </li>
                        @endif
                    @endif
                    @if (Auth::user())
                        @if (Auth::user()->role <= 2)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/balanceops') }}">Balance Operations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/topboosters') }}">Top Boosters</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/collections') }}">Collections</a>
                            </li>
                        @endif
                    @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Auth::user())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 mt-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
