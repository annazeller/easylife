<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Easylife Dashboard</title>
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
    <body class=" ">
        <div class='page-topbar '>
            <div class='logo-area'>
            </div>
            <div class='quick-area'>
                <div class='pull-left'>
                    <ul class="info-menu left-links list-inline list-unstyled">
                        <li class="sidebar-toggle-wrap">
                            <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                        
                    </ul>
                </div>
                <div class='pull-right'>
                    <ul class="info-menu right-links list-inline list-unstyled">
                        <li class="profile">
                            <a href="#" data-toggle="dropdown" class="toggle">
                                <img src="data/profile/profile.png" alt="user-image" class="img-circle img-inline">
                                <span>{{ Auth::user()->name }} <i class="fa fa-angle-down"></i></span>
                            </a>
                            <ul class="dropdown-menu profile animated fadeIn">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-wrench"></i>
                                        Einstellungen
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user"></i>
                                        Profil
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-info"></i>
                                        Hilfe
                                    </a>
                                </li>
                                <li class="last">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i>
                                        {{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="chat-toggle-wrapper">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-container row-fluid">
            <div class="page-sidebar ">
                <div class="page-sidebar-wrapper" id="main-menu-wrapper">
                    <div class="profile-info row">
                        <div class="profile-image col-md-4 col-sm-4 col-xs-4">
                            <a href="#">
                                <img src="data/profile/profile.png" class="img-responsive img-circle">
                            </a>
                        </div>
                        <div class="profile-details col-md-8 col-sm-8 col-xs-8">
                            <h3>
                            <a href="#">{{ Auth::user()->name }}</a>
                            <span class="profile-status online"></span>
                            </h3>
                            <p class="profile-title">Web Developer</p>
                        </div>
                    </div>
                    <ul class='wraplist'>
                        <li class="">
                            <a href="index.html">
                                <i class="fa fa-tachometer"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-tasks"></i>
                                <span class="title">Aufgaben</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-calendar"></i>
                                <span class="title">Kalender</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-suitcase"></i>
                                <span class="title">Projekte</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-bar-chart"></i>
                                <span class="title">Statistik</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-envelope"></i>
                                <span class="title">Nachrichten</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="javascript:;">
                                <i class="fa fa-cog"></i>
                                <span class="title">Einstellungen</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <section id="main-content" class=" ">
                <section class="wrapper main-wrapper" style=''>
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <div class="page-title">
                            <div class="pull-left">
                            <h1 class="title">Dashboard</h1>                            </div>
                            <div class="pull-right hidden-xs">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="index.html"><i class="fa fa-home"></i>Home</a>
                                    </li>
                                    <li class="active">
                                        <strong>Dashboard</strong>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title pull-left">Aufgaben</h2>
                                <div class="actions panel_actions pull-right">
                                    <i class="box_toggle fa fa-chevron-down"></i>
                                    <i class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></i>
                                    <i class="box_close fa fa-times"></i>
                                </div>
                            </header>
                            <div class="content-body">    <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <main class="py-4">
                                        @yield('content')
                                    </main>
                                </div>
                            </div>
                        </div>
                    </section></div>
                </section>
            </section>
        </div>    </div>
        <script src="{{ asset('js/jquery-1.11.2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/jquery.easing.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/pace/pace.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/viewport/viewportchecker.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/scripts.js') }}" type="text/javascript"></script>
        <div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Einstellungen</h4>
                    </div>
                    <div class="modal-body">
                        let's push things forward!
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">schließen</button>
                        <button class="btn btn-success" type="button">speichern</button>
                    </div>
                </div>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
