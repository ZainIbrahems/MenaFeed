<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <title>@yield('page_title', setting('admin.title') . " - " . setting('admin.description'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="assets-path" content="{{ route('voyager.voyager_assets') }}"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="{{ voyager_asset('images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif



<!-- App CSS -->
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">

    @yield('css')
    @if(__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif

<!-- Few Dynamic Styles -->
    <style type="text/css">
        .voyager .side-menu .navbar-header {
            background: {{ config('voyager.primary_color','#22A7F0') }};
            border-color: {{ config('voyager.primary_color','#22A7F0') }};
        }

        .widget .btn-primary {
            border-color: {{ config('voyager.primary_color','#22A7F0') }};
        }

        .widget .btn-primary:focus, .widget .btn-primary:hover, .widget .btn-primary:active, .widget .btn-primary.active, .widget .btn-primary:active:focus {
            background: {{ config('voyager.primary_color','#22A7F0') }};
        }

        .voyager .breadcrumb a {
            color: {{ config('voyager.primary_color','#22A7F0') }};
        }

        .add-form{
            padding-right: 15px !important;
            margin-bottom: 0px !important;
        }
    </style>

    @if(!empty(config('voyager.additional_css')))<!-- Additional CSS -->
    @foreach(config('voyager.additional_css') as $css)
        <link rel="stylesheet" type="text/css" href="{{ asset($css) }}">@endforeach
    @endif
    @stack('css')
    @yield('head')
</head>

<body class="voyager @if(isset($dataType) && isset($dataType->slug)){{ $dataType->slug }}@endif">


<?php
if (\Illuminate\Support\Str::startsWith(Auth::user()->personal_picture, 'http://') || \Illuminate\Support\Str::startsWith(Auth::user()->personal_picture, 'https://')) {
    $user_personal_picture = Auth::user()->personal_picture;
} else {
    $user_personal_picture = Voyager::image(Auth::user()->personal_picture);
}
?>

<div class="app-container">
    @yield('content')
</div>
{{--@include('voyager::partials.app-footer')--}}

<!-- Javascript Libs -->
</body>
</html>
