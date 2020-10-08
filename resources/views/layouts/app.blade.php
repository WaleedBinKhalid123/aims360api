<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('Fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        /* Style the links inside the sidenav */
        #mySidenav a {
            position: absolute; /* Position them relative to the browser window */
            left: -180px; /* Position them outside of the screen */
            transition: 0.3s; /* Add transition on hover */
            padding: 15px; /* 15px padding */
            width: 200px; /* Set a specific width */
            text-decoration: none; /* Remove underline */
            font-size: 20px; /* Increase font size */
            color: white; /* White text color */
            border-radius: 0 5px 5px 0; /* Rounded corners on the top right and bottom right side */
        }

        #mySidenav a:hover {
            left: 0; /* On mouse-over, make the elements appear as they should */
        }


        /* The about link: 20px from the top with a green background */
        #SHP {
            top: 50px;
            background-color: #737e8c;
        }

        #GQLP {
            top: 120px;
            background-color: #925353; /* Blue */
        }

        #projects {
            top: 140px;
            background-color: #925353; /* Red */
        }

        #contact {
            top: 200px;
            background-color: #555 /* Light Black */
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}" style="margin-left: 15px;">
                    {{ config('app.name', 'Laravel') }}
                <span style="color:white;padding-left: 2px;"><i class="fas fa-ship"></i></span></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
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
        <div id="mySidenav" class="sidenav">
            <a href="{{ route('SH_Products') }}" id="SHP">{{ __('ShipHeroProducts') }}</a>
            <a href="#" id="GQLP">{{ __('AimsProducts') }}</a>
        </div>
         <main>
            @yield('javascript')
        </main>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
