<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Easylife Registrieren</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/apple-touch-icon-114-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/apple-touch-icon-144-precomposed.png') }}">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="{{ asset('fonts/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" media="screen"/>
        <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" type="text/css"/>
        @stack('styles')
</head>
    <body class="login_page">
        <div class="login-wrapper">
            <div class="container text-center mt-4">
                <div class="row">
                    <div id="login" class="login loginpage col-md-8 col-md-offset-2">
                        <h1><a href="#" title="Registerquestion Page" tabindex="-1">Easylife</a></h1>
                    </div>
                    <div class="flex-center position-ref full-height">
               @if (Route::has('login'))
                   <div class="row content zentrum">
                       <div class="col-md-8 col-md-offset-2 mt-5">
                               <p style="color:white; font-size: 45px;">
                                   Herzlich Willkommen </br> bei easyLife
                               </p>
                               <p style="color:white; font-size: 20px; margin-top:30px; margin-bottom:30px;">
                                       EasyLife hilft Dir dabei Deinen Tagesablauf richtig zu planen. Trage einfach Deine To Dos ein und der EasyLife Kalender generiert Dir automatisch Deinen perfekten Tag.
                               </p>
                       <div class="col-md-6 col-md-offset-3">
                               <div class="col-sm-6 inline-block text-right">
                                    <a href="{{ url('/login') }}" class="register list-item btn btn-orange btn-block" id="login">Login</a>
                               </div>
                               <div class="col-sm-6 inline-block text-left">
                                    <a href="{{ url('/register') }}" class="register list-item btn btn-orange btn-block" id="register">Registrieren</a>
                               </div>
                       </div>
                       </div>
               @endif
                   </div>
                    </div>
                </div>
            </div>
    </body>
</html>
