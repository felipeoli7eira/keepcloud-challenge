<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page_title ?? 'Laravel app' }}</title>
    <link href="{{ asset('css/app/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/bootstrap-5/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/app.css') }}" rel="stylesheet">

    @yield('css')
</head>
<body>
    <div id="app" class="app">
        @yield('content')
    </div>

    <!-- Bootstrap 5.3.2 -->
    <script src="{{ asset('libs/bootstrap-5/dist/js/bootstrap.bundle.min.js') }}"></script>
    @yield('script')
</body>
</html>
