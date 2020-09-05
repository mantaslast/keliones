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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-2">
                        <div class="menu_logo_wrapper">
                            <a class="menu_logo" href="{{ url('/') }}">
                                <img src="/images/logo.png" alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="menu_items_wrapper">
                            <div class="menu_item">
                                <a href="#">asd</a>
                            </div>
                            <div class="menu_item">
                                <a href="#">www</a>
                            </div>
                            <div class="menu_item">
                                <a href="#">eee</a>
                            </div>
                            <div class="menu_item">
                                <a href="#">rrr</a>
                            </div>
                            <div class="menu_item">
                                <a href="#">asdas</a>
                            </div>
                            <div class="menu_item">
                                <a href="#">rrr</a>
                            </div>
                            <div class="menu_item">
                                <a href="#">rrr</a>
                            </div>
                            <div class="menu_item">
                                <a href="#">rrr</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-2">
                        <div class="menu_items_wrapper">
                            @guest
                                @if (Route::has('register'))
                                <div class="menu_item">
                                    <a class="menu_action" href="{{ route('register') }}"><i class="fas fa-user-plus"></i></a>
                                </div>
                                @endif
                                @if (Route::has('login'))
                                <div class="menu_item">
                                    <a class="menu_action" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i></a>
                                </div>
                                @endif
                            @else
                            <div class="menu_item">
                                <a class="menu_action" href="/profile">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                            </div>

                            <div class="menu_item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <a class="menu_action" href="javascript:void(0)">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                            </div>

                            <!-- <i class="fas fa-user-alt"></i> -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <login></login>
        <main>
            @yield('content')
        </main>
    </div>
    <script src="{{mix('js/app.js')}}"></script>
</body>
</html>
