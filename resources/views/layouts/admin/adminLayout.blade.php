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
<body style="
background: rgb(255,255,255); /* Old browsers */
background: -moz-linear-gradient(top,  rgba(255,255,255,1) 0%, rgba(229,229,229,1) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  rgba(255,255,255,1) 0%,rgba(229,229,229,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */
">
@if(isset($api_token))
<input type="hidden" value="{{ $api_token }}" id="api_token">
@endif
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
