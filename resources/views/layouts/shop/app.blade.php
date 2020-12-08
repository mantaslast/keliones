<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(isset($offer))
    <meta name="description" content="{{ strip_tags($offer->description) }}">
    <meta name="title" content="{{ $offer->name }}">
    @endif

    <title>{{ $title ?? 'Travel' }}</title>
    <link rel="preload" href="/fonts/Barlow-ExtraBold.ttf" as="font" crossorigin="anonymous">
    <link rel="preload" href="/fonts/Barlow-Medium.ttf" as="font" crossorigin="anonymous">
    <link rel="preload" href="/fonts/Barlow-Bold.ttf" as="font" crossorigin="anonymous">

    <script src="/js/common/common.js"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @if(isset($api_token))
    <input type="hidden" value="{{ $api_token }}" id="api_token">
    @endif
<div class="body_overlay" style="display:none;"></div>
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
                            @foreach($categories as $category)
                                <a href="/{{$category->slug}}" class="menu_item">
                                <span>{{ $category->name }}</span>
                                </a>
                            @endforeach
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
                                    <a onClick="loginPopupShow(event); return false;" class="menu_action" href="javascript:void(0);"><i class="fas fa-sign-in-alt"></i></a>
                                </div>
                                @endif
                            @else
                            <div class="menu_item">
                                <a class="menu_action" href="{{ route('profile') }}">
                                    <i class="fas fa-user-alt"></i>
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
        <div id="parentmsg" class="success-message mt-2" style="display: none;">
            <div id="msg" class="message">asd</div>
        </div>
        <app-login id="loginPopup" style="display:none;"></app-login>
        <main>
            @yield('content')
        </main>
    </div>
    <div class="container-fluid footer mt-3">
        <div style="height:60px;" class="row align-items-center">
            <div class="col-12 text-center">
                &copy; Travel, {{ date('yy', strtotime('now')) }}
            </div>
        </div>
    </div>
    <script src="{{mix('js/app.js')}}"></script>
</body>
</html>
