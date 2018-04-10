
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Easylife Register</title>
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
    <body class=" login_page">


        <div class="login-wrapper">
            <div id="login" class="login loginpage col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-0 col-xs-12">
                <h1><a href="#" title="Login Page" tabindex="-1">Easylife</a></h1>

                <form name="loginform" id="loginform" action="{{ route('register') }}" method="post">
                    @csrf
                    <p>
                        <label for="name">{{ __('Name') }}<br />
                            <input id="name" type="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                    </p>
                    <p>
                        <label for="email">{{ __('E-Mail Addresse') }}<br />
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                    </p>
                    <p>
                        <label for="password">{{ __('Passwort') }}<br />
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                    </p>
                    <p>
                        <label for="password-confirm">{{ __('Passwort bestätigen') }}<br />
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </p>



                    <p class="submit">
                        <button type="submit" class="btn btn-orange btn-block">
                                    {{ __('Registrieren') }}
                                </button>
                    </p>
                </form>

            </div>
        </div>
        <script src="{{ asset('js/jquery-1.11.2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/jquery.easing.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/pace/pace.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/viewport/viewportchecker.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/scripts.js') }}" type="text/javascript"></script>
        @stack('scripts')
    </body>
</html>