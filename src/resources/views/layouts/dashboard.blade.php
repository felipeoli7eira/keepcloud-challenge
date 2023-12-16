<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page_title ?? 'Laravel App' }}</title>

    <link href="{{ asset('css/app/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/bootstrap-5/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/app.css') }}" rel="stylesheet">

    @yield('css')
</head>
<body>
    <div id="app" class="app">
        <div class="container-fluid dashboard-main-grid">
            <div class="row">
                <div class="col col-2 p-0 m-0 navigation-side">
                    @component('components.dashboard.navbar')
                    @endcomponent
                </div>
                <div class="col col-10 p-0 m-0 dashboard-content p-5 content-side overflow-auto">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.2 -->
    <script src="{{ asset('libs/bootstrap-5/dist/js/bootstrap.bundle.min.js') }}"></script>
    @yield('script')
</body>
</html>
