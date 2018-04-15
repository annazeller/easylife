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
                    <div id="" class="login loginpage col-md-8 col-md-offset-2">
                        <h1><a href="#" title="Registerquestion Page" tabindex="-1">Easylife</a></h1>
                        <div class="">
                            <p>Herzlich Willkommen! Gleich kanns losgehen: Zuvor beantworte uns jedoch bitte einige Fragen zu deinem Alltag, damit wir Dir Deinen perfekten persönlichen easyLife Kalender erstellen können. Diese Angaben sind auch nachträglich in deinem Profil bearbeitbar.</p>
                            <form>
                                <div class="form-group">
                            <label class="control-label col-sm-2" for="sleephours">Wie lange willst Du schlafen?</label>
                            <div class="row">
                                <div class="inline h text-right">
                                <select class="dropdown" id="sleepHours_h">
                                    <option >00</option>
                                    <option >01</option>
                                    <option >02</option>
                                    <option >03</option>
                                    <option >04</option>
                                    <option >05</option>
                                    <option >06</option>
                                    <option >07</option>
                                    <option selected="selected">08</option>
                                    <option >09</option>
                                </select>h
                                </div>
                                <div class="inline min text-left">
                                <select class="dropdown" id="sleepHours_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >45</option>
                                    <option >50</option>
                                    <option >55</option>
                                </select>min
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="morningTime">Wie viel Zeit brauchst Du, um Dich morgens fertig zu machen?</label>
                            <div class="row">
                                <div class="inline h text-right">
                                <select class="dropdown" id="morningTime_h">
                                    <option >00</option>
                                    <option >01</option>
                                    <option >02</option>
                                </select>h
                                </div>
                                <div class="inline min text-left">
                                <select class="dropdown" id="morningTime_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option selected="selected">40</option>
                                    <option >45</option>
                                    <option >50</option>
                                    <option >55</option>
                                </select>min
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="eveningTime">Wie viel Zeit brauchst Du, um Dich Bettfertig zu machen?</label>
                            <div class="row">
                                <div class="inline h text-right">
                                <select class="dropdown" id="eveningTime_h">
                                    <option >00</option>
                                    <option >01</option>
                                </select>h
                                </div>
                                <div class="inline min text-left">
                                <select class="dropdown" id="eveningTime_min" name="duration">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option selected="selected">15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >45</option>
                                    <option >50</option>
                                    <option >55</option>
                                </select>min
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="workingHours">Wie viele Stunden arbeitest Du täglich? (incl. Pausen)</label>
                            <div class="row">
                                <div class="inline h text-right">
                                <select class="dropdown" id="workingHours_h">
                                    <option >01</option>
                                    <option >02</option>
                                    <option >03</option>
                                    <option >04</option>
                                    <option >05</option>
                                    <option >06</option>
                                    <option >07</option>
                                    <option selected="selected">08</option>
                                    <option >09</option>
                                </select>h
                                </div>
                                <div class="inline min text-left">
                                <select class="dropdown" id="workingHours_min">
                                    <option >00</option>
                                    <option >30</option>
                                </select>min
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="drive">Wie lange fährst Du auf die Arbeit?</label>
                            <div class="row">
                                <div class="inline h text-right">
                                <select class="dropdown" id="drive_h">
                                    <option >00</option>
                                    <option >01</option>
                                    <option >02</option>
                                    <option >03</option>
                                </select>h
                                </div>
                                <div class="inline min text-left">
                                <select class="dropdown" id="drive_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option selected="selected">20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >45</option>
                                    <option >50</option>
                                    <option >55</option>
                                </select>min
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="workingBegin">Wann beginnt Deine reguläre Arbeitszeit?</label>
                            <div class="row">
                                <div class="inline h text-right">
                                <select class="dropdown" id="workingBegin_h">
                                    <option >05</option>
                                    <option >06</option>
                                    <option >07</option>
                                    <option selected="selected">08</option>
                                    <option >09</option>
                                    <option >10</option>
                                    <option >11</option>
                                    <option >12</option>
                                    <option >13</option>
                                    <option >14</option>
                                    <option >15</option>
                                    <option >16</option>
                                    <option >17</option>
                                </select>:
                                </div>
                                <div class="inline min text-left">
                                <select class="dropdown" id="workingBegin_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >45</option>
                                    <option >50</option>
                                    <option >55</option>
                                </select>Uhr
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="breakfast">Wie lange frühstückst Du durchschnittlich?</label>
                            <div class="row">
                                <div class="inline h text-right">
                                <select class="dropdown" id="breakfast_h">
                                    <option >00</option>
                                    <option >01</option>
                                </select>h
                                </div>
                                <div class="inline min text-left">
                                <select class="dropdown" id="breakfast_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option selected="selected">20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >45</option>
                                    <option >50</option>
                                    <option >55</option>
                                </select>min
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="dinnertime">Wann isst Du zu Abend?</label>
                            <div class="row">
                                <div class="inline h text-right">
                                <select class="dropdown" id="dinnertime_h">
                                    <option >17</option>
                                    <option >18</option>
                                    <option selected="selected">19</option>
                                    <option >20</option>
                                    <option >21</option>
                                    <option >22</option>
                                    <option >23</option>
                                </select>:
                                </div>
                                <div class="inline min text-left">
                                <select class="dropdown" id="dinnertime_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >45</option>
                                    <option >50</option>
                                    <option >55</option>
                                </select>Uhr
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="dinner">Wie lange isst Du zu Abend?</label>
                            <div class="row">
                                <div class="inline h text-right">
                                <select class="dropdown" id="dinner_h">
                                    <option >00</option>
                                    <option >01</option>
                                    <option >02</option>
                                </select>h
                                </div>
                                <div class="inline min text-left">
                                <select class="dropdown" id="dinner_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option selected="selected">30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >45</option>
                                    <option >50</option>
                                    <option >55</option>
                                </select>min
                                </div>
                            </div>
                        </div>

                    </form>
                            <div class="col-md-6 col-md-offset-4">
                                <div class="col col-lg-8">
                            <button id="submit1" class="btn btn-orange btn-block">
                                Bestätigen
                            </button>
                            </div>
                            </div>
                </div>

                    </div>
                </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#submit1', function () {
            console.log($('#workingBegin_h').val());
            $.ajax({
                type: 'POST',
                url: "registerstep1",
                dataType: 'text',
                data: {
                    'user_id': 2,
                    'dinner_h': $('#dinner_h').val(),
                    'dinner_min': $('#dinner_min').val(),
                    'dinner_time_h': $('#dinnertime_h').val(),
                    'dinner_time_min': $('#dinnertime_min').val(),
                    'breakfast_h': $('#breakfast_h').val(),
                    'breakfast_min': $('#breakfast_min').val(),
                    'morningTime_h': $('#morningTime_h').val(),
                    'morningTime_min': $('#morningTime_min').val(),
                    'sleepHours_h': $('#sleepHours_h').val(),
                    'sleepHours_min': $('#sleepHours_min').val(),
                    'eveningTime_h': $('#eveningTime_h').val(),
                    'eveningTime_min': $('#eveningTime_min').val(),
                    'drive_h': $('#drive_h').val(),
                    'drive_min': $('#drive_min').val(),
                    'workingHours_h': $('#workingHours_h').val(),
                    'workingHours_min': $('#workingHours_min').val(),
                    'workingBegin_h': $('#workingBegin_h').val(),
                    'workingBegin_min': $('#workingBegin_min').val(),
                },
                success: function (data) {
                    window.location.href = "/register";                }
            });
        });
    });
</script>
</html>

