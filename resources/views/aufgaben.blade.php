@extends('layouts.main')
@section('content')
@section('title', 'Aufgaben')
<style>
.hidden{
display: none;
}
.inline{
display: inline-block;
}
</style>
<div class="row">
    <button class="btn btn-default" id="buttonNewToDO" type="button" data-toggle="modal" data-target="#create"> Aufgaben erstellen</button>
    <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#showall" aria-expanded="false" aria-controls="showall">
    Aufgaben anzeigen
    </button>
</div>
<div class="collapse" id="showall">
    <div class="card card-body">
        <!-- Liste aller persönlichen ToDos -->
        <div id="todos"><br>
            <h3>ToDo:</h3>
            <div class="offene">
            @foreach ($todos as $todo)
                @if ($todo->completed == 0)
            <div id="{{$todo->id}}">
                <div class="titel">
                    {{ $todo->titel }}
                </div>
                <table id="example" class="display table table-hover table-condensed" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Status</th><th>Titel</th><th>Beschreibung</th><th>Priorität</th><th>Aufwand</th><th>Ort</th><th></th>                 </tr>
                        </thead>
                        <tbody>
                            <tr><td id="{{$todo->id}}">@if ($todo->completed == 1)
                                        <input value="{{$todo->id}}" class="inline checkbox btn btn-default" type="checkbox" checked>
                                    @else
                                        <input value="{{$todo->id}}" class="inline checkbox btn btn-default" type="checkbox">
                                    @endif</td><td id="{{$todo->id}}title">{{ $todo->title }}</td><td id="{{$todo->id}}description">{{ $todo->description }}</td><td id="{{$todo->id}}priority">{{ $todo->priority }}</td><td id="{{$todo->id}}duration">{{ date('H:i', mktime(0, ( $todo->duration ))) }}</td><td id="{{$todo->id}}location">{{ $todo->location }}</td><td><div class="buttons pull-right">
                            <button value="{{$todo->id}}" class="btn btn-danger btn-dell">löschen</button>
                            <button value="{{$todo->id}}" class="btn btn-default edit" type="button" data-toggle="modal" data-target="#edit">
                            bearbeiten
                            </button>

                        </div></td></tr>
                    </tbody>
                </table>
            </div>
                @endif
            @endforeach
            </div>


            <h3>Erledigt:</h3>
            <div class = "done">
            @foreach ($todos as $todo)
                @if ($todo->completed == 1)
                        <div id="{{$todo->id}}">
                            <div class="titel">
                                {{ $todo->titel }}
                            </div>
                            <table id="example" class="display table table-hover table-condensed" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Status</th><th>Titel</th><th>Beschreibung</th><th>Priorität</th><th>Aufwand</th><th>Ort</th><th></th>                 </tr>
                                </thead>
                                <tbody>
                                <tr><td id="{{$todo->id}}">@if ($todo->completed == 1)
                                            <input value="{{$todo->id}}" class="inline checkbox btn btn-default" type="checkbox" checked>
                                        @else
                                            <input value="{{$todo->id}}" class="inline checkbox btn btn-default" type="checkbox">
                                        @endif</td><td id="{{$todo->id}}title">{{ $todo->title }}</td><td id="{{$todo->id}}description">{{ $todo->description }}</td><td id="{{$todo->id}}priority">{{ $todo->priority }}</td><td id="{{$todo->id}}duration">{{ date('H:i', mktime(0, ( $todo->duration ))) }}</td><td id="{{$todo->id}}location">{{ $todo->location }}</td><td><div class="buttons pull-right">
                                            <button value="{{$todo->id}}" class="btn btn-danger btn-dell">löschen</button>
                                            <button value="{{$todo->id}}" class="btn btn-default edit" type="button" data-toggle="modal" data-target="#edit">
                                                bearbeiten
                                            </button>

                                        </div></td></tr>
                                </tbody>
                            </table>
                        </div>
                @endif
            @endforeach
            </div>
        </div>
        <!-- Liste aller persönlichen ToDos ENDE -->
    </div>
</div>

<!-- Edit a todo -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close clearerror" data-dismiss="modal" aria-label="Close" aria-hidden="true">&times;</button>
                <h5 class="modal-title">Aufgabe bearbeiten</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger hidden errormessage" role="alert">
                    Bitte gib mindestens einen Titel für dein überarbeitetes ToDo an.
                </div>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Titel:*</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title_edit" autofocus >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="description">Beschreibung:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="description_edit" cols="20" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="priority">Priorität:</label>
                        <div class="col-sm-10">
                            <select id="priority_edit">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="duration">Aufwand:</label>
                        <div class="col-sm-10">
                            <select id="duration_edit_h">
                                <option>00</option>
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                                <option>05</option>
                                <option>06</option>
                                <option>07</option>
                                <option>08</option>
                                <option>09</option>
                            </select>h
                            <select id="duration_edit_min">
                                <option>00</option>
                                <option>05</option>
                                <option>10</option>
                                <option>15</option>
                                <option>20</option>
                                <option>25</option>
                                <option>30</option>
                                <option>35</option>
                                <option>40</option>
                                <option>45</option>
                                <option>50</option>
                                <option>55</option>
                            </select>min
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="location">Ort:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="location_edit" autofocus>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success editsubmit" data-dismiss="modal">Speichern</button>
            </div>
        </div>
    </div>
</div>
<!-- Create a todo -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close clearerror" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Aufgabe erstellen</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger hidden errormessage" role="alert">
                    Bitte gib mindestens einen Titel für dein neues ToDo an.
                </div>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Titel:*</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title_create" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="description">Beschreibung:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="description_create" cols="20" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="priority">Priorität:</label>
                        <div class="col-sm-10">
                            <select id="priority_create">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="duration">Aufwand:</label>
                        <div class="col-sm-10 ">
                            <div class="inline h">
                                <select id="duration_create_h">
                                    <option >00</option>
                                    <option >01</option>
                                    <option >02</option>
                                    <option >03</option>
                                    <option >04</option>
                                    <option >05</option>
                                    <option >06</option>
                                    <option >07</option>
                                    <option >08</option>
                                    <option >09</option>
                                </select>h
                            </div>
                            <div class="inline min">
                                <select id="duration_create_min">
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
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="location">Ort:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="location_create" autofocus>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default clearerror" type="button">schließen</button>
                <button type="button" class="btn btn-success createsubmit" data-dismiss="modal">speichern</button>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var idToEdit;



        $(document).on('click', '.btn-dell', function() {
            var idElementToDelete = $(this).val();
            var divToRemove = $('#'+idElementToDelete);
            $.ajax({
                type: 'POST',
                url: "deleteAjax",
                dataType: 'text',
                data: {
                    'id': idElementToDelete
                },
                success: function (data) {
                    $(divToRemove).remove();
                }
            });
        });

        $(document).on('click', '.checkbox', function() {
            var idElementCheck = $(this).val();
            var prepareElement = '#' + idElementCheck;
            var div = $(prepareElement);

            $.ajax({
                type: 'POST',
                url: "done",
                dataType: 'text',
                data: {
                    'id': idElementCheck
                },
                success: function (data) {

                    var json = JSON.parse(data);

                    if(json.completed === 1) {
                        $(".done").append(div);
                    }
                    else if(json.completed === 0)
                    {
                        $(".offene").append(div);
                    }
                }
            });
        });

        $(".createsubmit").click(function () {
            var validatedata = {};
            validatedata.title = $('#title_create').val(),
            validatedata.priority = $('#priority_create').val();
            validatedata.duration_h = $('#duration_create_h').val();
            validatedata.duration_min = $('#duration_create_min').val();

            for (i in validatedata) {
                if ($.trim(validatedata[i]) === "") {
                    $( ".errormessage" ).removeClass( 'hidden' );

                    return false;
                }
            }


            $.ajax({
                type: 'POST',
                url: "todos",
                dataType: 'text',
                data: {
                    'title': $('#title_create').val(),
                    'description': $('#description_create').val(),
                    'priority': $('#priority_create').val(),
                    'duration_h': $('#duration_create_h').val(),
                    'duration_min': $('#duration_create_min').val(),
                    'location': $('#location_create').val(),
                },
                success: function (data) {
                    var json = JSON.parse(data);
                    var newtodo = "<div id="+json.id+"><div class='titel'><div class='buttons'><button value="+json.id+" class='btn-dell'>x</button><button value="+json.id+" class='edit' type='button' data-toggle='modal' data-target='#edit'>Edit</button></div></div><div>Titel:<div class='inline' id="+json.id+'title'+">"+json.title+"</div></div><div>Beschreibung:<div class='inline' id="+json.id+'description'+">"+json.description+"</div></div><div>Priorität:<div class='inline' id="+json.id+'priority'+">"+json.priority+"</div></div> <div>Aufwand:<div class='inline' id="+json.id+'duration'+">"+json.duration+"</div></div><div class='inline'>Ort:<div class='inline' id="+json.id+'location'+">"+json.location+"</div></div></div>";
                    $( "#todos" ).load(" #todos, #showall, newtodo");
                    $('#title_create').val('');
                    $('#description_create').val('');
                    $('#priority_create').val('');
                    $('#duration_create_h').val(0);
                    $('#duration_create_min').val(30);
                    $('#location_create').val('');

                    $( ".errormessage" ).addClass( 'hidden' );
                }
            });
        });

        $(document).on('click', '.edit', function() {
            var idElementToEdit = $(this).val();
            idToEdit = idElementToEdit;

            $('#title_edit').val(document.getElementById (idElementToEdit+'title').innerHTML);
            $('#description_edit').val(document.getElementById (idElementToEdit+'description').innerHTML);
            $('#location_edit').val(document.getElementById (idElementToEdit+'location').innerHTML);

            $('#priority_edit').val(document.getElementById (idElementToEdit+'priority').innerHTML);

            var durationsplit = (document.getElementById (idElementToEdit+'duration').innerHTML).split(":");
            durationsplit[0];
            durationsplit[1];

            $('#duration_edit_h').val(durationsplit[0]);
            $('#duration_edit_min').val(durationsplit[1]);

            $('#edit').modal('show');
        });
        $(".editsubmit").click(function () {
            var validatedata = {};
            validatedata.title = $('#title_edit').val(),
                validatedata.priority = $('#priority_edit').val();
            validatedata.duration_h = $('#duration_edit_h').val();
            validatedata.duration_min = $('#duration_edit_min').val();

            for (i in validatedata) {
                if ($.trim(validatedata[i]) === "") {
                    $( ".errormessage" ).removeClass( 'hidden' );

                    return false;
                }
            }


            $.ajax({
                type: 'PUT',
                url: "todos/"+idToEdit,
                dataType: 'text',
                data: {
                    'title': $('#title_edit').val(),
                    'description': $('#description_edit').val(),
                    'priority': $('#priority_edit').val(),
                    'duration_min': $('#duration_edit_min').val(),
                    'duration_h': $('#duration_edit_h').val(),
                    'location': $('#location_edit').val(),
                },
                success: function (data) {
                    var json = JSON.parse(data);
                    var replacetitle = idToEdit+'title';
                    var replacedescription = idToEdit+'description';
                    var replacelocation = idToEdit+'location';
                    var replaceduration = idToEdit+'duration';
                    var replacepriority = idToEdit+'priority';

                    document.getElementById(replacetitle).innerHTML = json.title;
                    document.getElementById(replacedescription).innerHTML = json.description;
                    document.getElementById(replacelocation).innerHTML = json.location;

                    var h = '0'+ Math.floor(json.duration /60);
                    var min = json.duration % 60;

                    if(min < 10)
                    {
                        min = '0' + min;
                    }

                    document.getElementById(replaceduration).innerHTML = h + ":" +min;
                    document.getElementById(replacepriority).innerHTML = json.priority;
                }
            });
        });


        $(".clearerror").click(function () {
            $( ".errormessage" ).addClass( 'hidden' );
        });
    });
</script>