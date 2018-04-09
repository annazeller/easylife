@extends('layouts.main')


@section('content')
    <style>
        .hidden{
            display: none;
        }
    </style>
    <!-- Neues ToDo erstellen -->
    <button class="btn btn-default" id="buttonNewToDO" type="button" data-toggle="modal" data-target="#create">Neue Aufgabe</button>

    <!-- Liste aller persönlichen ToDos -->
    <div id="todos">
    @foreach ($todos as $todo)
        <div id="{{$todo->id}}">
            <div class="titel">
                {{ $todo->titel }}
                    <div class="buttons">
                        <button value="{{$todo->id}}" class="btn-dell">x</button>
                        <button value="{{$todo->id}}" class="edit" type="button" data-toggle="modal" data-target="#edit">
                            Edit
                        </button>
                    </div>
            </div>
            <div>Titel:<div id="{{$todo->id}}title">{{ $todo->title }}</div>
            </div>
            <div>Beschreibung:<div id="{{$todo->id}}description">{{ $todo->description }}</div>
            </div>
            <div>Priorität:<div id="{{$todo->id}}priority">{{ $todo->priority }}</div>
            </div>
            <div>Aufwand:<div id="{{$todo->id}}duration">{{ $todo->duration }}</div>
            </div>
            <div>Ort:<div id="{{$todo->id}}location">{{ $todo->location }}</div>
            </div>
        </div>
    @endforeach
    </div>
    <!-- Liste aller persönlichen ToDos ENDE -->

    <!-- Edit a todo -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aufgabe bearbeiten</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title">Titel:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title_edit" autofocus>
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
                                <input type="text" class="form-control" id="priority_edit" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="duration">Aufwand:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="duration_edit" autofocus>
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
                    <h5 class="modal-title">Aufgabe erstellen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title">Titel:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title_create" autofocus>
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
                                <input type="text" class="form-control" id="priority_create" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="duration">Aufwand:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="duration_create" autofocus>
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
                    <button type="button" class="btn btn-success createsubmit" data-dismiss="modal">Speichern</button>
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

        $(".btn-dell").click(function () {
            var idElementToDelete = $(this).val();
            console.log(idElementToDelete);
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

        $(".createsubmit").click(function () {
            $.ajax({
                type: 'POST',
                url: "todos",
                dataType: 'text',
                data: {
                    'title': $('#title_create').val(),
                    'description': $('#description_create').val(),
                    'priority': $('#priority_create').val(),
                    'duration': $('#duration_create').val(),
                    'location': $('#location_create').val(),
                },
                success: function (data) {
                    var json = JSON.parse(data);

                    var newtodo = "<div id="+json.id+"><div class='titel'><div class='buttons'><button value="+json.id+" class='btn-dell'>x</button><button value="+json.id+" class='edit' type='button' data-toggle='modal' data-target='#edit'>Edit</button></div></div><div>Titel:<div id="+json.id+'title'+">"+json.title+"</div></div><div>Beschreibung:<div id="+json.id+'description'+">"+json.description+"</div></div><div>Priorität:<div id="+json.id+'priority'+">"+json.priority+"</div></div> <div>Aufwand:<div id="+json.id+'duration'+">"+json.duration+"</div></div><div>Ort:<div id="+json.id+'location'+">"+json.location+"</div></div></div>";

                    $( "#todos" ).append( newtodo );

                    $('#title_create').val('');
                    $('#description_create').val('');
                    $('#priority_create').val('');
                    $('#duration_create').val('');
                    $('#location_create').val('');
                }
            });
        });

        $(document).on('click', '.edit', function() {
            var idElementToEdit = $(this).val();
            idToEdit = idElementToEdit;
            console.log(idToEdit);

            $('#title_edit').val(document.getElementById (idElementToEdit+'title').innerHTML);
            $('#description_edit').val(document.getElementById (idElementToEdit+'description').innerHTML);
            $('#location_edit').val(document.getElementById (idElementToEdit+'location').innerHTML);
            $('#duration_edit').val(document.getElementById (idElementToEdit+'duration').innerHTML);
            $('#priority_edit').val(document.getElementById (idElementToEdit+'priority').innerHTML);

            $('#edit').modal('show');
        });

        $(".editsubmit").click(function () {
            console.log(idToEdit);

            $.ajax({
                type: 'PUT',
                url: "todos/"+idToEdit,
                dataType: 'text',
                data: {
                    'title': $('#title_edit').val(),
                    'description': $('#description_edit').val(),
                    'priority': $('#priority_edit').val(),
                    'duration': $('#duration_edit').val(),
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
                    document.getElementById(replaceduration).innerHTML = json.duration;
                    document.getElementById(replacepriority).innerHTML = json.priority;
                }
            });
        });

    });

</script>

