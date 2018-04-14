@extends('layouts.main')
@section('title', 'Profil')
@section('content')
<div class="col-lg-12">
    <section class="box nobox">
        <div class="content-body">    <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="uprofile-image">
                    <img src="/data/profile/{{ $user->avatar }}" class="img-responsive" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                </div>
                <div class="uprofile-name">
                    <h3>
                    {{ $user->name }}'s Profil
                    </h3>
                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="uprofile-content">
                    <div class="">
                        <h4>Dein Alltag:</h4>
                        <p>Hier kannst du deine persönlichen Alltagsangaben anzeigen und auch bearbeiten.</p><br>
                        <div id="easylifequestions">
                            <div>
                                <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#showall" aria-expanded="#showall" aria-controls="showall">Anzeigen</button>
                                <button class="btn btn-default edit" type="button" data-toggle="modal" data-target="#edit">Neu festlegen</button>
                            </div>
                            
                            <br>
                            <div class="collapse" id="showall">
                                <div class="card card-body">
                                    <div>
                                        <p>Du schläfst pro Tag durschnittlich: {{ date('H:i', mktime(0, ( $user->sleephours )))}} h</p>
                                    </div>
                                    <div>
                                        <p>Durchschnittlich frühstückst du: {{ date('H:i', mktime(0, ( $user->breakfast ))) }} h</p>
                                    </div>
                                    <div>
                                        <p>Du arbeitest täglich: {{ date('H:i', mktime(0, ( $user->workingHours )))  }} h</p>
                                    </div>
                                    <div>
                                        <p>Deine Arbeitszeit beginnt um: {{ date('g:ia', strtotime($user->workingBegin)) }}</p>
                                    </div>
                                    <div>
                                        <p>Dein Arbeitsweg beträgt: {{ date('H:i', mktime(0, ( $user->drive ))) }} h</p>
                                    </div>
                                    <div>
                                        <p>Durschnittliche morgentliche Herrichtzeit: {{ date('H:i', mktime(0, ( $user->morningTime ))) }} h</p>
                                    </div>
                                    <div>
                                        <p>Durschnittliche morgentliche Zeit dich bettfertig zu machen: {{ date('H:i', mktime(0, ( $user->eveningTime ))) }} h</p>
                                    </div>
                                    <div>
                                        <p>Abends isst du meistens: {{ date('H:i', mktime(0, ( $user->dinner ))) }} h</p>
                                    </div>
                                    <div>
                                        <p>Abends isst du meistens um: {{ date('g:ia', strtotime($user->dinnertime))  }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section></div>
<!-- Edit EasyLife question Angaben -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Alltagsdaten neu festlegen</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="sleephours">Wie lange willst Du schlafen?</label>
                        <div class="col-sm-6">
                            <div class="inline h">
                                <select id="sleepHours_h">
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
                            <div class="inline min">
                                <select id="sleepHours_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >50</option>
                                    <option >45</option>
                                    <option >55</option>
                                </select>min
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="morningTime">Wie viel Zeit brauchst Du, um Dich morgens fertig zu machen?</label>
                        <div class="col-sm-6 ">
                            <div class="inline h">
                                <select id="morningTime_h">
                                    <option >00</option>
                                    <option >01</option>
                                    <option >02</option>
                                </select>h
                            </div>
                            <div class="inline min">
                                <select id="morningTime_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option selected="selected">40</option>
                                    <option >50</option>
                                    <option >45</option>
                                    <option >55</option>
                                </select>min
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="eveningTime">Wie viel Zeit brauchst Du, um Dich Bettfertig zu machen?</label>
                        <div class="col-sm-6 ">
                            <div class="inline h">
                                <select id="eveningTime_h">
                                    <option >00</option>
                                    <option >01</option>
                                </select>h
                            </div>
                            <div class="inline min">
                                <select id="eveningTime_min" name="duration">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option selected="selected">15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >50</option>
                                    <option >45</option>
                                    <option >55</option>
                                </select>min
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="workingHours">Wie viele Stunden arbeitest Du täglich? (incl. Pausen)</label>
                        <div class="col-sm-6 ">
                            <div class="inline h">
                                <select id="workingHours_h">
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
                            <div class="inline min">
                                <select id="workingHours_min">
                                    <option >00</option>
                                    <option >30</option>
                                </select>min
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="drive">Wie lange fährst Du auf die Arbeit?</label>
                        <div class="col-sm-6 ">
                            <div class="inline h">
                                <select id="drive_h">
                                    <option >00</option>
                                    <option >01</option>
                                    <option >02</option>
                                    <option >03</option>
                                </select>h
                            </div>
                            <div class="inline min">
                                <select id="drive_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option selected="selected">20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >50</option>
                                    <option >45</option>
                                    <option >55</option>
                                </select>min
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="workingBegin">Wann beginnt Deine reguläre Arbeitszeit?</label>
                        <div class="col-sm-6 ">
                            <div class="inline h">
                                <select id="workingBegin_h">
                                    <option >05</option>
                                    <option >06</option>
                                    <option >07</option>
                                    <option selected="selected">08</option>
                                    <option >09</option>
                                    <option >10</option>
                                    <option >11</option>
                                    <option >12</option>
                                    <option >03</option>
                                    <option >04</option>
                                    <option >05</option>
                                    <option >06</option>
                                    <option >07</option>
                                    <option >08</option>
                                    <option >09</option>
                                    <option >10</option>
                                    <option >11</option>
                                    <option >12</option>
                                    <option >13</option>
                                    <option >14</option>
                                </select>:
                            </div>
                            <div class="inline min">
                                <select id="workingBegin_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >50</option>
                                    <option >45</option>
                                    <option >55</option>
                                </select>Uhr
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="breakfast">Wie lange frühstückst Du durchschnittlich?</label>
                        <div class="col-sm-6 ">
                            <div class="inline h">
                                <select id="breakfast_h">
                                    <option >00</option>
                                    <option >01</option>
                                </select>h
                            </div>
                            <div class="inline min">
                                <select id="breakfast_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option selected="selected">20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >50</option>
                                    <option >45</option>
                                    <option >55</option>
                                </select>min
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="dinnertime">Wann isst Du zu Abend?</label>
                        <div class="col-sm-6 ">
                            <div class="inline h">
                                <select id="dinnertime_h">
                                    <option >17</option>
                                    <option >18</option>
                                    <option selected="selected">19</option>
                                    <option >20</option>
                                    <option >21</option>
                                    <option >22</option>
                                    <option >23</option>
                                </select>:
                            </div>
                            <div class="inline min">
                                <select id="dinnertime_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option >30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >50</option>
                                    <option >45</option>
                                    <option >55</option>
                                </select>Uhr
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-6" for="dinner">Wie lange isst Du zu Abend?</label>
                        <div class="col-sm-6 ">
                            <div class="inline h">
                                <select id="dinner_h">
                                    <option >00</option>
                                    <option >01</option>
                                    <option >02</option>
                                </select>h
                            </div>
                            <div class="inline min">
                                <select id="dinner_min">
                                    <option >00</option>
                                    <option >05</option>
                                    <option >10</option>
                                    <option >15</option>
                                    <option >20</option>
                                    <option >25</option>
                                    <option selected="selected">30</option>
                                    <option >35</option>
                                    <option >40</option>
                                    <option >50</option>
                                    <option >45</option>
                                    <option >55</option>
                                </select>min
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">schließen</button>
                <button type="button" class="btn btn-success" id="editquestionssubmit" data-dismiss="modal">speichern</button>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#editquestionssubmit', function () {
            $.ajax({
                type: 'PUT',
                url: "registerquestions",
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
                    console.log('success');
                    window.location.href = "/profile";
                }
            });
        });
    });
</script>