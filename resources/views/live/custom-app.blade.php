<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <style type="text/css">
        :root {
            --primary-color: {{ getSetting('PRIMARY_COLOR')->color.'dd' }};
            --primary-color-disabled: {{ getSetting('PRIMARY_COLOR_DISABLED')->color }};
            --secondary-color: {{ getSetting('SECONDARY_COLOR')->color }};
        }
    </style>
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/fa.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('logo.png')}}">
    @yield('style')
</head>
<body>
<div id="app">
{{--    @if(!isset($is_webview) || (isset($is_webview) && !$is_webview))--}}
{{--        <nav class="navbar navbar-expand-md shadow-sm">--}}
{{--            <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--                <img src="{{ asset('assets/images/logo-white.png') }}"--}}
{{--                     alt="{{ getSetting('APPLICATION_NAME')->text }}" width="75px">--}}
{{--            </a>--}}
{{--            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"--}}
{{--                    aria-controls="navbarSupportedContent" aria-expanded="false"--}}
{{--                    aria-label="{{ __('Toggle navigation') }}">--}}
{{--                <span class="navbar-toggler-icon"></span>--}}
{{--            </button>--}}

{{--            <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--                <!-- Left Side Of Navbar -->--}}
{{--                <ul class="navbar-nav mr-auto">--}}

{{--                </ul>--}}

{{--            </div>--}}
{{--        </nav>--}}
{{--    @endif--}}
    <main class="py-4 mb-5 mb-md-0">
        @yield('content')
    </main>

</div>

<script>
    var url = "{{url('/')}}";
</script>
<!-- Scripts -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
{{--@toastr_js--}}
{{--@toastr_render--}}
@yield('script')
</body>
</html>
