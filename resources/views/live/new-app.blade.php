<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

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
    <link href="{{ asset('assets/css/meeting-new.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ Voyager::image(getSetting('FAVICON')->image)}}">
    @yield('style')
</head>

<body>

@yield('content')


<script>
    var url = "{{url('/')}}";
</script>
<!-- Scripts -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
@yield('script')

</body>

</html>
