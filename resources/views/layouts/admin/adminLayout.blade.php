<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preload" href="/fonts/Barlow-ExtraBold.ttf" as="font" crossorigin="anonymous">
    <link rel="preload" href="/fonts/Barlow-Medium.ttf" as="font" crossorigin="anonymous">
    <link rel="preload" href="/fonts/Barlow-Bold.ttf" as="font" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="body_overlay" style="display:none;"></div>
    <div id="app">
        <main>
            @include('admin.sidebar')
            @yield('content')
        </main>
    </div>
    <script src="{{mix('js/app.js')}}"></script>
    <script src="/js/admin/admin.js"></script>
</body>
</html>
