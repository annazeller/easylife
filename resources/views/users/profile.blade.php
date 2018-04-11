@extends('layouts.main')
 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <img src="/data/profile/{{ $user->avatar }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
            <h2>{{ $user->name }}'s Profile</h2>
            <form enctype="multipart/form-data" action="/profile" method="POST">
                <label>Update Profile Image</label>
                <input type="file" name="avatar">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"><br />
                <input type="submit" class="btn btn-orange">
            </form>

            <div id="easylifequestions">
                <button class="edit" type="button" data-toggle="modal" data-target="#edit">
                    Edit
                </button>
            <div> Du schläfst pro Tag durschnittlich: {{ $user->sleephours }} h
            </div>
            <div> Durchschnittlich frühstückst du: {{ $user->breakfast }} h
            </div>
            <div> Du arbeitest täglich: {{ $user->workingHours }} h
            </div>
            <div> Deine Arbeitszeit beginnt um: {{ $user->workingBegin }}
            </div>
            <div> Dein Arbeitsweg beträgt: {{ $user->drive }} h
            </div>
            <div> Durschnittliche morgentliche Herrichtzeit: {{ $user->morningTime }} h
            </div>
            <div> Durschnittliche morgentliche Zeit dich bettfertig zu machen: {{ $user->eveningTime }} h
            </div>
            <div> Abends isst du meistens: {{ $user->dinner }} h
            </div>
            <div> Abends isst du meistens um: {{ $user->dinnertime }}
            </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Angaben aktualisieren</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form">

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success editsubmit" data-dismiss="modal">Speichern</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection