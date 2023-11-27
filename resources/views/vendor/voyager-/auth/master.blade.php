<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>@yield('title', 'Admin - '.Voyager::setting("admin.title"))</title>
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    @if (__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif
    <style>
        body {
            background-image:url('{{ Voyager::image( Voyager::setting("admin.bg_image"), voyager_asset("images/bg.jpg") ) }}');
            background-color: {{ Voyager::setting("admin.bg_color", "#FFFFFF" ) }};
        }
        body.login .login-sidebar {
            border-top:5px solid {{ config('voyager.primary_color','#22A7F0') }};
        }
        @media (max-width: 767px) {
            body.login .login-sidebar {
                border-top:0px !important;
                border-left:5px solid {{ config('voyager.primary_color','#22A7F0') }};
            }
        }
        body.login .form-group-default.focused{
            border-color:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .login-button, .bar:before, .bar:after{
            background:{{ config('voyager.primary_color','#22A7F0') }};
        }
        .remember-me-text{
            padding:0 5px;
        }
        .login-button, .bar:before, .bar:after{
            background: #0074c7;
        }
    </style>
{{--    <style>--}}
{{--        @font-face {--}}
{{--            font-family: myFirstFont;--}}
{{--            src: url('{{asset('Crimson/CrimsonPro-VariableFont_wght.ttf')}}');--}}
{{--        }--}}

{{--        div,p,input,select,textarea,a,h1,h2,h3,h4,h5,h6,span,label,.btn {--}}
{{--            font-family: myFirstFont !important;--}}
{{--        }--}}
{{--    </style>--}}
    @yield('pre_css')
{{--    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">--}}
</head>
<body class="login" style="background-image: none;background: none;">
<div class="container-fluid">
    <div class="row">
{{--        <div class="faded-bg animated"></div>--}}
        <div   style="
            background-image: url({{Voyager::image(Voyager::setting('admin.bg_image', '')) }});
            background-color: #FFFFFF;
            height: 100vh;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;" class="hidden-xs col-sm-7 col-md-7">
            <div class="clearfix">
                <div class="col-sm-12 col-md-10 col-md-offset-2">
                    <div class="logo-title-container">
{{--                        <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>--}}
{{--                        @if($admin_logo_img == '')--}}
{{--                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">--}}
{{--                        @else--}}
{{--                            <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">--}}
{{--                        @endif--}}
{{--                        <div class="copy animated fadeIn">--}}
{{--                            <h1>{{ Voyager::setting('admin.title', 'Voyager') }}</h1>--}}
{{--                            <p>{{ Voyager::setting('admin.description', __('voyager::login.welcome')) }}</p>--}}
{{--                        </div>--}}
                    </div> <!-- .logo-title-container -->
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-5 col-md-5 login-sidebar">

           @yield('content')

        </div> <!-- .login-sidebar -->
    </div> <!-- .row -->
</div> <!-- .container-fluid -->
@yield('post_js')
</body>
</html>
