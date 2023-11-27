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

        .ml-5{
            margin-left: 5px;
        }

        .read-btn{
            padding: 0 5px;
            margin: 0;
        }
        .voyager .side-menu.sidebar-inverse{
            background: #0074c7 !important;
            color: white;
        }

        .voyager .side-menu .navbar-header{
            background: #0074c7;
            border-color: #0074c7;
        }

        .voyager .side-menu.sidebar-inverse .navbar li>a{
            color: #fff;
        }

        .voyager .side-menu.sidebar-inverse .navbar li>a:hover{
            background: #0068b3;
            color: #fff;
        }

        .app-container .content-container .side-menu .navbar-header .navbar-brand img{
            display: inline-block;
            max-height: 100%;
            max-width: 100%;
            position: relative;
            margin: auto;
            padding: 2% 5%;
            background: white;
            border-radius: 5px;
        }


        .app-container .content-container .side-menu .navbar-header .navbar-brand .logo-icon-container{
            display: inline-block;
            height: 60px;
            width: 100%;
            text-align: center;
        }

        .expanded .side-menu .panel.widget .dimmer, .side-menu:hover .panel.widget .dimmer{
            background: linear-gradient(275deg,#0074c79c,rgb(0 116 199 / 46%) 34%,rgb(0 116 199 / 63%));
        }

        .btn.btn-primary{
            background: #0074c7;
        }

        .control-label{
            color: #0074c7;
            font-weight: bold;
        }

        .btn-lang.active{
            background: #d4d4d4;
            border-radius: 20px;
        }

        .panel.widget .dimmer{
            background: linear-gradient(135deg,rgb(0 116 199 / 44%),rgb(0 116 199 / 51%)) !important;
        }

            /*.form-control,.select2-container{*/
            /*    border: none !important;*/
            /*    border-bottom: 2px solid #0074c7 !important;*/
            /*}*/
        .app-container.expanded .content-container .side-menu .navbar-header .navbar-brand .title, .app-container.expanded .content-container .side-menu .navbar-nav li a .title{
            font-size: 14px;
        }

        .app-container .content-container .side-menu .navbar-nav li.dropdown ul li a{
            height: 33px;
            line-height: 33px;
        }

    </style>

    @if(!empty(config('voyager.additional_css')))<!-- Additional CSS -->
    @foreach(config('voyager.additional_css') as $css)
        <link rel="stylesheet" type="text/css" href="{{ asset($css) }}">@endforeach
    @endif

{{--    <style>--}}
{{--        @font-face {--}}
{{--            font-family: myFirstFont;--}}
{{--            src: url('{{asset('Crimson/CrimsonPro-VariableFont_wght.ttf')}}');--}}
{{--        }--}}

{{--        div,p,input,select,textarea,a,h1,h2,h3,h4,h5,h6,label,.btn {--}}
{{--            font-family: myFirstFont !important;--}}
{{--        }--}}
{{--    </style>--}}
    @stack('css')
    @yield('head')
</head>

<body class="voyager @if(isset($dataType) && isset($dataType->slug)){{ $dataType->slug }}@endif">

<div id="voyager-loader">
    <?php $admin_loader_img = Voyager::setting('admin.loader', ''); ?>
    @if($admin_loader_img == '')
        <img src="{{ voyager_asset('images/logo-icon.png') }}" alt="Voyager Loader">
    @else
        <img src="{{ Voyager::image($admin_loader_img) }}" alt="Voyager Loader">
    @endif
</div>

<?php
if (\Illuminate\Support\Str::startsWith(Auth::user()->personal_picture, 'http://') || \Illuminate\Support\Str::startsWith(Auth::user()->personal_picture, 'https://')) {
    $user_personal_picture = Auth::user()->personal_picture;
} else {
    $user_personal_picture = Voyager::image(Auth::user()->personal_picture);
}
?>

<div class="app-container">
    <div class="fadetoblack visible-xs"></div>
    <div class="row content-container">
        @include('voyager::dashboard.navbar')
        @include('voyager::dashboard.sidebar')
        <script>
            (function () {
                var appContainer = document.querySelector('.app-container'),
                    sidebar = appContainer.querySelector('.side-menu'),
                    navbar = appContainer.querySelector('nav.navbar.navbar-top'),
                    loader = document.getElementById('voyager-loader'),
                    hamburgerMenu = document.querySelector('.hamburger'),
                    sidebarTransition = sidebar.style.transition,
                    navbarTransition = navbar.style.transition,
                    containerTransition = appContainer.style.transition;

                sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
                    appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                        navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

                if (window.innerWidth > 768 && window.localStorage && window.localStorage['voyager.stickySidebar'] == 'true') {
                    appContainer.className += ' expanded no-animation';
                    loader.style.left = (sidebar.clientWidth / 2) + 'px';
                    hamburgerMenu.className += ' is-active no-animation';
                }

                navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
                sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
                appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition = containerTransition;
            })();
        </script>
        <!-- Main Content -->
        <div class="container-fluid">
            <div class="side-body padding-top">
                @yield('page_header')
                <div id="voyager-notifications"></div>
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('voyager::partials.app-footer')

<!-- Javascript Libs -->


<script type="text/javascript" src="{{ voyager_asset('js/app.js') }}"></script>

<script>
    @if(Session::has('alerts'))
    let alerts = {!! json_encode(Session::get('alerts')) !!};
    helpers.displayAlerts(alerts, toastr);
    @endif

    @if(Session::has('message'))

    // TODO: change Controllers to use AlertsMessages trait... then remove this
    var alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
    var alertMessage = {!! json_encode(Session::get('message')) !!};
    var alerter = toastr[alertType];

    if (alerter) {
        alerter(alertMessage);
    } else {
        toastr.error("toastr alert-type " + alertType + " is unknown");
    }
    @endif
</script>
@include('voyager::media.manager')
@yield('javascript')
@stack('javascript')
@if(!empty(config('voyager.additional_js')))<!-- Additional Javascript -->
@foreach(config('voyager.additional_js') as $js)
    <script type="text/javascript" src="{{ asset($js) }}"></script>@endforeach
@endif

</body>
</html>
