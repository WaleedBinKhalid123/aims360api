<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('Fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('SPL') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .breadcrumb {
            background: transparent;
            margin: 0 0 1.25rem;
            margin-left: 5px;
        }
        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 1rem;
            list-style: none;
        }
        #aims360_products_filter{
            float: right;
        }
        #shiphero_products_filter{
            float: right;
        }
        #modal_products_filter{
            float: right;
        }
        #match_products_filter{
            float: right;
        }
        #shiphero_products_filter input {
            border-radius: 10px;
            height: 35px;
            margin-left: 5px;
        }
        #aims360_products_filter input{
            border-radius: 10px;
            height: 35px;
            margin-left: 5px;
        }
        #match_products_filter input{
            border-radius: 10px;
            height: 35px;
            margin-left: 5px;
        }
        #modal_products_filter input{
            border-radius: 10px;
            height: 35px;
            margin-right: 20px;
            margin-left: 5px;
        }
        .content{
            display: none;
        }
        .preloader{
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%,-50%);
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 20px 1px rgba(0, 0, 0, 0.06), 0 1px 4px rgba(0, 0, 0, 0.08);
            border: 0;
        }
        #shiphero_products_info{
            display: none;
        }
    </style>
    <script>
        $(function(){
            $(".preloader").fadeOut(1000,function (){
                $(".content").fadeIn(500);
            });
        });
    </script>
</head>
<body>
    <div class="preloader">
        <img src="images/6.gif">
    </div>
        <div class="content">
        <nav class="navbar navbar-expand-md bg-white shadow-sm">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}" style="margin-left: 15px;color:black;">
                    {{ config('app.name', 'Laravel') }}
                <span style="color:black;padding-left: 2px;"><i class="fas fa-ship"></i></span></a>
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
                                <a class="nav-link" style="color:black;" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" style="color:black;" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                            <li class="nav-item"><a class="nav-link" style="color:black;" href="{{ route('SH_Products') }}">{{ __('ShipHeroProducts') }}</a></li>
                            <li class="nav-item"><a class="nav-link" style="color:black;" href="{{ route('A360_Products') }}">{{ __('AimsProducts') }}</a></li>
                            <li class="nav-item"><a class="nav-link" style="color:black;" href="{{ route('Match_Products') }}">{{ __('MatchProducts') }}</a></li>

                            <a style="color:black" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="color:black;">

                                    <a class="dropdown-item"  href="{{ route('logout') }}"
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
        <main>
            @yield('javascript')
        </main>
        <main class="py-4">
            @yield('content')
        </main>
        </div>
</body>
</html>
